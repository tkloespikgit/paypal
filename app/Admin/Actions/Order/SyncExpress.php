<?php

namespace App\Admin\Actions\Order;

use App\Events\ExpressNoUploaded;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class SyncExpress extends RowAction
{
    public $name = '同步运单至TG';

    public function handle(Model $model)
    {
        ExpressNoUploaded::dispatch($model);
        return $this->response()->success('同步成功.')->refresh();
    }

}
