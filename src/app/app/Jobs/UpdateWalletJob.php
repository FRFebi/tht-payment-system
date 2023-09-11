<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class UpdateWalletJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $walletName;
    protected $amount;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $walletName, $amount)
    {
        $this->userId = $userId;
        $this->walletName = $walletName;
        $this->amount = $amount;
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
                $sqlUpdate = "UPDATE wallet SET balance = balance - ? WHERE user_id = ? and wallet_name = ?";
                DB::update($sqlUpdate,[$this->amount,$this->userId,$this->walletName]);
            }
        }
        // $affected = DB::update($sql, [$this->userId, $this->walletName]);
    }

    public function middleware(){
        return [(new WithoutOverlapping($this->userId))->releaseAfter(60)];
    }
}
