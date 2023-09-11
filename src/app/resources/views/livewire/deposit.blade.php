<div>
  <div class="card">
    <div class="card-header text-center">
      Deposit
    </div>
    <div class="card-body">
      <form class="text-center" action="/deposit" method="post">
        @csrf
        <div class="mb-3">
          <input type="number" class="form-control" name="amount" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
    <div class="card-footer text-body-secondary">
      This submit function is randomly generated with 50% success chance. Please be patient if the transaction is still
      failed
    </div>
  </div>
</div>