<?php

namespace App\Http\Controllers;

use App\Jobs\AddWalletJob;
use App\Jobs\SubstractWalletJob;
use App\Jobs\UpdateWalletJob;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function deposit (Request $request){
        $amount = (int) $request->amount;
        $orderId = $this->getId();
        $userId = 1;
        $timestamp = (string)Carbon::now()->timestamp;
        $walletName = "wallet_test";

        $status = $this->DepositOrWithdrawPaymentAPI($orderId, $amount,$timestamp);
        $this->saveOrderToDB($orderId, $amount, $status, "deposit",$timestamp);
        if ($status == 1){
            dispatch(new AddWalletJob($userId, $walletName, $amount));
            $value = "ok";
        }else{
            $value = "not ok";
        }
        return redirect()->route('dashboard');
    }

    public function withdraw(Request $request){
        $amount = (int)$request->amount;
        $orderId = $this->getId();
        $userId = 1;
        $walletName = "wallet_test";
        $timestamp = (string)Carbon::now()->timestamp;

        dispatch(new SubstractWalletJob($userId, $walletName, $amount, $orderId,$timestamp));
        return redirect()->route('dashboard');
    }


    public function getId(){
        $userId = "01";
        $random = rand(1,1000);
        $now = Carbon::now();
        $year =$now->isoFormat('YYYY');
        $month =$now->isoFormat('MM');
        $date =$now->isoFormat('DD');
        $hour =$now->isoFormat('HH');
        $minute =$now->isoFormat('mm');
        $second =$now->isoFormat('ss');
        $milisecond =$now->isoFormat('SSS');

        return $userId.$year.$month.$date.$hour.$minute.$second.$milisecond.$random;
    }

    // public function decrease($userId,$walletName,$amount){
    public function decrease(){
        $sql = "SELECT balance FROM wallet WHERE user_id = ? and wallet_name = ?";
        $result = DB::select($sql,[1, "wallet_test"]);
        if(count($result)>0){
            if($result[0]->balance >= 10000){
                $sqlUpdate = "UPDATE wallet SET balance = balance - ? WHERE user_id = ? and wallet_name = ?";
                DB::update($sqlUpdate,[10000,1,"wallet_test"]);
            }
        }
    }

    public function DepositOrWithdrawPaymentAPI($orderId,$amount,$timestamp){
        try{
            $client = new Client();

            $app_token = base64_encode("FikoRedhaFebiansyah");

            $headers = [
                "Content-Type" => "application/json",
                "Authorization" => "Bearer ".$app_token
            ];

            $body = [
                "order_id"=> $orderId, 
                "amount"=> $amount,
                "timestamp"=> $timestamp
            ];
            $option = [
                "headers"=> $headers,
                "json"=> $body,
            ];
            $response = $client->request("POST","http://localhost:8888/deposit",$option);
        }catch(ClientException $e){
            // dd($e);
            return 2;
        }
        return json_decode($response->getBody())->status;
    }

    public function saveOrderToDB($orderId, $amount, $status, $type,$timestamp){
        $sql = "INSERT INTO tht.order (trans_id, amount, `status`, `action`,`timestamp`) VALUES ( ?,?,?,?,?);";
        // DB::insert($sql);
        DB::insert($sql, [$orderId, $amount, $status,$type,$timestamp]);
    }
}
