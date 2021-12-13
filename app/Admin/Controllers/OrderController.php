<?php

namespace App\Admin\Controllers;

use App\Models\OrderInfo;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class OrderController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OrderInfo';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderInfo());
        
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like( 'name','客户名字');
            $filter->like( 'receiver_email','收款人邮箱');
            $filter->like( 'porder_no','PayPal 订单号');
            $filter->date( 'created_at', '创建时间');
        });
        $grid->expandFilter();
        
        $grid->column('order_number', '系统单号')->filter('like');
        $grid->column('porder_no', 'PayPal 订单号')->filter('like');
        $grid->column('email', '客户邮箱')->filter('like');
        $grid->column('receiver_email', '收款人邮箱')->filter('like');
        $grid->column('name', '客户名字');
        $grid->column('total_amount', '金额(USD)');
        $grid->column('status', '状态')->display(function ($status) {
            if ($status == 0) {
                return '未完成';
            } else {
                return '已完成';
            }
        })->filter([
            0 => '未完成',
            1 => '已完成'
        ]);
        $grid->column('express', '快递公司');
        $grid->column('express_no', '快递单号');
        $grid->column('created_at', '创建时间')->display(function ($created_at){
            return date('Y-m-d H:i:s',strtotime($created_at));
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
            "USPS" => "USPS",
            "顺丰速运" => "顺丰速运",
            "Four PX Express" => "4PX Express",
            "Fedex" => "联邦快递",
            "DHL" => "DHL",
            "邮政" => "邮政"
            ];
        $form->text('order_number', '系统单号')->disable();
        $form->text('porder_no', 'Paypal 订单号')->disable();
        $form->email('email', '客户邮箱')->disable();
        $form->email('receiver_email', '收款人邮箱')->disable();
        $form->text('name', '客户名字')->disable();
        $form->decimal('total_amount', '总金额')->disable();
        $form->decimal('discount_amount', '显示折扣')->disable();
        $form->switch('status','状态');
        $form->select('express', '快递公司')->options($options);
        $form->text('express_no', '快递单号');

        return $form;
    }
}
