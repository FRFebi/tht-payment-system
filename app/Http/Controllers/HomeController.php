<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $wallet = $this->getWalletInfo(1,"wallet_test");
        $orders = $this->getOrders();
        return view('home',["wallet"=>$wallet,"orders"=>$orders]);
    }

    public function getWalletInfo($userId,$walletName){
        $sql = "SELECT wallet_name,balance FROM wallet WHERE user_id = ? and wallet_name = ?";
        $result = DB::select($sql,[$userId, $walletName]);
        return $result[0];
    }

    public function getOrders(){
        $sql = "SELECT id,trans_id,amount, action, status,created_at FROM `order` ORDER BY created_at DESC LIMIT 10";
        $result = DB::select($sql);
        return $result;
    }
}
