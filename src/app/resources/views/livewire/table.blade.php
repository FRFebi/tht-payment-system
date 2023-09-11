<div>
    <div class="card">
        <div class="card-header text-center">
            Order Transaction
        </div>
        <div class="card-body ">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">trans_id</th>
                        <th scope="col">amount</th>
                        <th scope="col">action</th>
                        <th scope="col">status</th>
                        <th scope="col">created_date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <th scope="row">{{$order->id}}</th>
                        <td>{{$order->trans_id}}</td>
                        <td>{{$order->amount}}</td>
                        <td>{{$order->action}}</td>
                        <td>{{$order->status}}</td>
                        <td>{{$order->created_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>