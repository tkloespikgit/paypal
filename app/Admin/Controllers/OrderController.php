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

        $grid->column('id', __('Id'));
        $grid->column('order_number', '系统单号')->searchable();
        $grid->column('porder_no', 'PayPal 订单号')->searchable();
        $grid->column('email', '客户邮箱')->searchable();
        $grid->column('name', '客户名字');
        $grid->column('total_amount', '交易金额');
        $grid->column('discount_amount', '显示折扣');
        $grid->column('status', '状态')->display(function ($status) {
            if ($status == 0) {
                return '未完成';
            } else {
                return '已完成';
            }
        })->searchable();
        $grid->column('express', '快递公司');
        $grid->column('express_no', '快递单号');
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '更新时间');

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

        $form->text('order_number', '系统单号')->disable();
        $form->text('porder_no', '系统单号')->disable();
        $form->email('email', '客户邮箱')->disable();
        $form->text('name', '客户名字')->disable();
        $form->decimal('total_amount', '总金额')->disable();
        $form->decimal('discount_amount', '显示折扣')->disable();
        $form->switch('status','状态');
        $form->text('express', '快递公司');
        $form->text('express_no', '快递单号');

        return $form;
    }
}
