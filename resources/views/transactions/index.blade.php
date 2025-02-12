@extends('transactions.layout')
   
@section('content')
  
<div class="mt-5 card">
  <h2 class="card-header">Income and Expense</h2>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('transactions.create') }}"> <i class="fa fa-plus"></i> Create New</a>
        </div>
  
        <table class="table mt-4 table-bordered table-striped">
            <thead>
                <tr>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Amount</th>
                    <th>Notes</th>
                    <th>Date</th>
                    <th>Method</th>
                </tr>
            </thead>
  
            <tbody>

                
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ ($transaction->debitAccountHead->name== "Bank" || $transaction->debitAccountHead->name== "Cash") ? '-' : $transaction->debitAccountHead->name}}</td>
                    <td>{{($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash") ? '-' : $transaction->creditAccountHead->name }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->notes }}</td>
                    <td>{{ $transaction->transaction_date }}</td>
                    <td>{{ $transaction->method }}</td>

                    {{-- <td>{{($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash" ) ?  $transaction->creditAccountHead->name:'-' }}</td> --}}
                    
                    {{-- dd($transaction) --}}
                </tr>
            @endforeach
                <tr>
                    <th>Cash in Hand</th>
                    <td>{{ $cashHand }}</td>
                </tr>
                <tr>
                    <th>Cash in Bank</th>
                    <td>{{ $cashBank }}</td>
                </tr>
                
            </tbody>
  
        </table>
        
        {{-- {!! $accountHeads->links() !!} --}}
  
  </div>
</div>  
@endsection