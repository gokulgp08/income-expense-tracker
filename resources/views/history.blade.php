@extends('transactions.layout')
   
@section('content')

<div style="display: flex; padding: 10px;">
    <a href="transactions" style="padding: 10px;">Dashboard</a>
    <a href="history" style="padding: 10px;">History</a>
</div>

<div class="mt-5 card">
  <h2 class="card-header">Transaction History</h2>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <table class="table mt-4 table-bordered table-striped">
            <thead>
                <tr>
                    <th>Account Head</th>
                    <th>Amount</th>
                    <th> Credit/Debit </th>
                    <th>Payment</th>
                </tr>
            </thead>
  
            <tbody>

                
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->head }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->transfer }}</td>
                    <td>{{ $transaction->method }}</td>

                    {{-- <td>{{($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash" ) ?  $transaction->creditAccountHead->name:'-' }}</td> --}}
                    
                    {{-- dd($transaction) --}}
                </tr>
            @endforeach
            </tbody>
  
        </table>
        
        {!! $transactions->links() !!}
  
  </div>
</div>  
@endsection