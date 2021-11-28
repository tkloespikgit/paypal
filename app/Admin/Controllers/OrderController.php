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
        $grid->column('order_number', __('Order number'));
        $grid->column('email', __('Email'));
        $grid->column('name', __('Name'));
        $grid->column('total_amount', __('Total amount'));
        $grid->column('discount_amount', __('Discount amount'));
        $grid->column('status', __('Status'));
        $grid->column('express', __('Express'));
        $grid->column('express_no', __('Express no'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show->field('order_number', __('Order number'));
        $show->field('email', __('Email'));
        $show->field('name', __('Name'));
        $show->field('total_amount', __('Total amount'));
        $show->field('discount_amount', __('Discount amount'));
        $show->field('status', __('Status'));
        $show->field('express', __('Express'));
        $show->field('express_no', __('Express no'));
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
        $form = new Form(new OrderInfo());

        $form->text('order_number', __('Order number'));
        $form->email('email', __('Email'));
        $form->text('name', __('Name'));
        $form->decimal('total_amount', __('Total amount'));
        $form->decimal('discount_amount', __('Discount amount'));
        $form->switch('status', __('Status'));
        $form->text('express', __('Express'));
        $form->text('express_no', __('Express no'));

        return $form;
    }
}
