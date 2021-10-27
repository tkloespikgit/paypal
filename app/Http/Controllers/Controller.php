<?php

namespace App\Http\Controllers;

use App\Models\PaypalAccount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function showAccounts()
    {
        $accounts = PaypalAccount::query()
            ->where('status',1)
            ->orderBy('last_resp')
            ->first();
        if ($accounts == null)
        {
            return "No accounts !";
        }
        $accounts->last_resp=time();
        $accounts->save();
        return $accounts->account_html;
    }
}
