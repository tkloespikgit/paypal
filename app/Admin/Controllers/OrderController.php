<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Order\OrderProductDetails;
use App\Admin\Actions\Order\SyncExpress;
use App\Events\ExpressNoUploaded;
use App\Models\OrderInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use function GuzzleHttp\Promise\all;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OrderInfo';

    /**
     * @var
     */
    public $input;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid(): Grid
    {
        $grid = new Grid(new OrderInfo());

        $grid->actions(function ($actions) {
            $actions->add(new SyncExpress);
            $actions->add(new OrderProductDetails);
        });

        $grid->model()->orderBy('id', 'desc');

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->column(1 / 2, function ($filter) {
                $filter->like('name', '客户名字');
                $filter->like('email', '客户邮箱');
                $filter->like('porder_no', 'PayPal 订单号');
                $filter->like('order_number', '系统订单号');

                $filter->where(function ($query) {
                    if ($this->input != 'all') {
                        $query->where('pm', $this->input);
                    }
                }, '付款方式', 'pm_type')->radio([
                    'all'        => '全部',
                    'paypal'     => 'Paypal',
                    'creditCard' => '信用卡',
                ]);
            });

            $filter->column(1 / 2, function ($filter) {
                $filter->like('receiver_email', '收款人邮箱');
                $filter->date('created_at', '订单日期');
                $filter->where(function ($query) {
                    switch ($this->input) {
                        case 'yes':
                            $query->where('status', 1);
                            break;
                        case 'no':
                            $query->where('status', 0);
                            break;
                        case 'failed':
                            $query->whereNull('status', 2);
                            break;
                    }
                }, '订单状态', 'status_paid')->radio([
                    'all'    => '全部',
                    'yes'    => '已支付',
                    'no'     => '未支付',
                    'failed' => '支付失败',
                ]);
                $filter->where(function ($query) {
                    switch ($this->input) {
                        case 'yes':
                            $query->whereNotNull('express_no');
                            break;
                        case 'no':
                            $query->whereNull('express_no');
                            break;
                    }
                }, '运单号', 'express_no_entered')->radio([
                    'all' => '全部',
                    'yes' => '已填写',
                    'no'  => '未填写',
                ]);
                $filter->where(function ($query) {
                    switch ($this->input) {
                        case 1:
                            $query->where('express_status', 1);
                            break;
                        case 0:
                            $query->where('express_status', 0);
                            break;
                    }
                }, '运单状态', 'express_status_n')->radio([
                    -1 => '全部',
                    1  => '已同步',
                    0  => '未同步',
                ]);
            });
        });
        $grid->expandFilter();

        $grid->column('order_number', '系统单号');
        $grid->column('porder_no', '收款方单号');
        $grid->column('pm', '付款方式');
        $grid->column('email', '客户邮箱');
        $grid->column('receiver_email', '收款人邮箱');
        $grid->column('total_amount', '金额(USD)');
        $grid->column('status', '状态')->display(function ($status) {
            if ($status == 0) {
                return '未支付';
            } elseif ($status == 2) {
                return '付款失败';
            } else {
                return '已支付';
            }
        });
        $grid->column('express', '快递公司');
        $grid->column('express_no', '快递单号');
        $grid->column('express_status', '运单状态')->display(function ($express_status) {
            if ($express_status == 0) {
                return "未同步";
            } else {
                return "已同步";
            }

        });
        $grid->column('created_at', '创建时间')->display(function ($created_at) {
            return date('Y-m-d H:i:s', strtotime($created_at));
        });


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(OrderInfo::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_number', '系统单号');
        $show->field('porder_no', 'Paypal 单号');
        $show->field('email', '客户邮箱');
        $show->field('receiver_email', '收款人邮箱');
        $show->field('name', '客户名字');
        $show->field('total_amount', '总金额');
        $show->field('discount_amount', '显示折扣');
        $show->field('status', '状态');
        $show->field('express', '快递公司');
        $show->field('express_no', '快递单号');
        $show->field('created_at', '创建时间');
        $show->field('updated_at', '更新时间');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrderInfo());

        $options = [
            "USPS"            => "USPS",
            "顺丰速运"            => "顺丰速运",
            "Four PX Express" => "4PX Express",
            "Fedex"           => "联邦快递",
            "DHL"             => "DHL",
            "邮政"              => "邮政",
            "YunExpress"      => "YunExpress",
            "TNT"             => "TNT",
        ];
        $form->text('order_number', '系统单号')->disable();
        $form->text('porder_no', 'Paypal 订单号')->disable();
        $form->email('email', '客户邮箱')->disable();
        $form->email('receiver_email', '收款人邮箱')->disable();
        $form->text('name', '客户名字')->disable();
        $form->decimal('total_amount', '总金额')->disable();
        $form->decimal('discount_amount', '显示折扣')->disable();
        $form->switch('status', '状态');
        $form->select('express', '快递公司')->options($options);
        $form->text('express_no', '快递单号')
            ->updateRules(['required', "unique:order_infos,express_no,{{id}}"]);

        $form->saved(function (Form $form) {
            ExpressNoUploaded::dispatch(OrderInfo::query()->find($form->model()->id));
        });
        return $form;
    }
}
