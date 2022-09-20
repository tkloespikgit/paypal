<?php

namespace App\Admin\Controllers;

use App\Models\OrderAddress;
use Carbon\Carbon;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class AddressController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'OrderAddress';


    /**
     * @var
     */
    public $input;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OrderAddress());

        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->column(1 / 2, function ($filter) {
                $filter->like('address_name', '客户名字');
                $filter->like('payer_email', '客户邮箱');
                $filter->like('pp_order_no', 'PayPal 订单号');
                $filter->like('order_no', '系统订单号');
            });

            $filter->column(1 / 2, function ($filter) {
                $filter->date('created_at', '订单日期');
            });
        });
        $grid->expandFilter();

        $grid->column('order_no', __('系统单号'))->display(function ($order_no) {
            return "<a href='/showBill/{$order_no}' target='_blank'>{$order_no}</a>";
        });
        $grid->column('pp_order_no', __('Paypal 订单号'));
        $grid->column('first_name', __('名字'));
        $grid->column('last_name', __('姓氏'));
        $grid->column('address_name', __('收货人名称'));
        $grid->column('address_country_code', __('国家代码'));
        $grid->column('address_country', __('国家'));
        $grid->column('address_state', __('州/省'));
        $grid->column('address_city', __('城市'));
        $grid->column('address_street', __('街道'));
        $grid->column('address_zip', __('邮编'));
        $grid->column('payer_email', __('付款人邮箱'));
        $grid->column('created_at', __('付款时间'))->display(function ($created_at){
            return  date('Y-m-d H:i:s',strtotime($created_at));
        });

        $grid->export(function ($export) {

            $export->filename(date('Y-m-d') . '-代发快递.csv');
            $export->originalValue(['order_no']);
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
        $show = new Show(OrderAddress::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('order_id', __('Order id'));
        $show->field('order_no', __('Order no'));
        $show->field('pp_order_no', __('Pp order no'));
        $show->field('first_name', __('First name'));
        $show->field('last_name', __('Last name'));
        $show->field('address_name', __('Address name'));
        $show->field('address_country_code', __('Address country code'));
        $show->field('address_country', __('Address country'));
        $show->field('address_state', __('Address state'));
        $show->field('address_city', __('Address city'));
        $show->field('address_street', __('Address street'));
        $show->field('address_zip', __('Address zip'));
        $show->field('payer_email', __('Payer email'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OrderAddress());

        $form->number('order_id', __('Order id'));
        $form->text('order_no', __('Order no'));
        $form->text('pp_order_no', __('Pp order no'));
        $form->text('first_name', __('First name'));
        $form->text('last_name', __('Last name'));
        $form->text('address_name', __('Address name'));
        $form->text('address_country_code', __('Address country code'));
        $form->text('address_country', __('Address country'));
        $form->text('address_state', __('Address state'));
        $form->text('address_city', __('Address city'));
        $form->text('address_street', __('Address street'));
        $form->text('address_zip', __('Address zip'));
        $form->text('payer_email', __('Payer email'));

        return $form;
    }
}
