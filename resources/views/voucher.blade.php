@extends('layout')
   
@section('content')



<div class="mt-5 card">
  <h2 class="card-header">Vouchers</h2>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <table class="table mt-4 table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2">Voucher Number</th>
                    <th colspan="2" style="text-align: center;">Transfer</th>
                    {{-- <th>To</th> --}}
                    <th rowspan="2">Amount</th>
                    <th rowspan="2">Created By</th>
                    <th rowspan="2">Created On</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
  
            <tbody>

                
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->voucherNumber->voucher_no }}</td>
                    <td>{{ $transaction->debitAccountHead->name }}</td>
                    <td>{{ $transaction->creditAccountHead->name }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->transaction_date }}</td>

                    {{-- <td>{{($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash" ) ?  $transaction->creditAccountHead->name:'-' }}</td> --}}
                    
                    {{-- dd($transaction) --}}
                </tr>
            @endforeach
            </tbody>
  
        </table>
        
        {{-- {!! $transactions->links() !!} --}}
  
  </div>
</div>  
@endsection