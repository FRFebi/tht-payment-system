<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;


class SubstractWalletJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $userId;
    protected $walletName;
    protected $amount;
    protected $orderId;
    protected $timestamp;
    /**
     * Create a new job instance.
     */
public function __construct($userId, $walletName, $amount, $orderId,$timestamp)
    {
        $this->userId = $userId;
        $this->walletName = $walletName;
        $this->amount = $amount;
        $this->orderId = $orderId;
        $this->timestamp = $timestamp;
    }

    /**
     * Execute the job.
     */
      public function handle(): void
    {
        $sql = "SELECT balance FROM wallet WHERE user_id = ? and wallet_name = ?";
        $result = DB::select($sql,[$this->userId, $this->walletName]);

        if(count($result)>0){
            if($result[0]->balance >= $this->amount){
                $status = $this->DepositOrWithdrawPaymentAPI($this->orderId,$this->amount,$this->timestamp);
                $this->saveOrderToDB($this->orderId, $this->amount, $status, "withdraw",$this->timestamp);
                if ($status==1){
                    $sqlUpdate = "UPDATE wallet SET balance = balance - ? WHERE user_id = ? and wallet_name = ?";
                    DB::update($sqlUpdate,[$this->amount,$this->userId,$this->walletName]);
                }
            }
        }
    }

    public function middleware(){
        return [(new WithoutOverlapping($this->userId))->releaseAfter(60)];
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
            $response = $client->request("POST","http://go-server:8888/deposit",$option);
        }catch(ClientException $e){
            // dd($e);
            return 2;
        }
        return json_decode($response->getBody())->status;
    }

    public function saveOrderToDB($orderId, $amount, $status, $type,$timestamp){
        $sql = "INSERT INTO `order` (trans_id, amount, `status`, `action`,`timestamp`) VALUES ( ?,?,?,?,?);";
        // DB::insert($sql);
        DB::insert($sql, [$orderId, $amount, $status,$type,$timestamp]);
    }
}
