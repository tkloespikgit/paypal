<?php

namespace App\Admin\Controllers;

use App\Models\PaypalAccount;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaypalAccountController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Paypal账户管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PaypalAccount());

        $grid->column('id', "ID");
        $grid->column('account_name', "账户名称");
        $grid->column('account_email', "邮箱");
        $grid->column('status', "状态")->display(function ($status) {
            if ($status == 0) {
                return '暂停';
            } elseif ($status == 1) {
                return '启用';
            } else {
                return '禁用';
            }
        });
        $grid->column('last_resp', '最近使用时间')->display(function ($last_resp){
            return date('Y/m/d H:i:s');
        })->sortable();
        $grid->column('balance', '余额');
        $grid->column('currency', '币种');
        $grid->column('created_at', '创建时间');

        $grid->paginate(20);
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
        $show = new Show(PaypalAccount::findOrFail($id));

        $show->field('id', "ID");
        $show->field('account_name', "账户名称");
        $show->field('account_email', "邮箱");
        $show->field('status', "状态");
        $show->field('last_resp', __('Last resp'));
        $show->field('balance', __('Balance'));
        $show->field('currency', __('Currency'));
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
        $form = new Form(new PaypalAccount());

        $form->text('account_name', __('Account name'));
        $form->text('account_email', __('Account email'));
        $form->textarea('account_html', __('Account html'));
        $form->text('status', __('Status'));
        $form->number('last_resp', __('Last resp'));
        $form->decimal('balance', __('Balance'))->default(0.00);
        $form->text('currency', __('Currency'))->default('USD');

        return $form;
    }
}
