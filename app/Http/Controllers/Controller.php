<?php

namespace App\Http\Controllers;

use App\Models\PaypalAccount;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function showAccounts()
    {
        $accounts = $this->getAccounts();
        if ($accounts == null)
        {
            return "No accounts !";
        }
        $accounts->last_resp=time();
        $accounts->save();
        return $accounts->account_html;
    }



    public function payNow(Request $request)
    {
        if (!$request->has(['item_name','item_number','amount','shipping','invoice'])){
            return 'error happened!';
        }
        $accounts = $this->getAccounts();
        if ($accounts == null)
        {
            return "No accounts !";
        }
        $accounts->last_resp=time();
        $accounts->save();
        return view('paymentForm',compact('request','accounts'));
    }




    private function getAccounts()
    {
        return PaypalAccount::query()
            ->where('status',1)
            ->orderBy('last_resp')
            ->first();
    }

}
