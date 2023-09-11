<div>
    <div class="card">
        <h5 class="card-header text-center">Wallet</h5>
        <div class="card-body">
            <h5 class="card-title">Wallet name: {{$wallet->wallet_name}}</h5>
            <p class="card-text">Amount Rp. {{ $wallet->balance}}</p>
        </div>
        <div class="card-footer text-body-secondary">
            This wallet display is not synchronized automatically, Please refresh if the transaction is success
        </div>
    </div>
</div>