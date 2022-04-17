<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;

class HomeController extends Controller
{
    public function index(Content $content): Content
    {

        return $content
            ->header('Chartjs')
            ->body(
                new Box(
                    '数据报表',
                    view('admin.chart')
                ));
    }
}
