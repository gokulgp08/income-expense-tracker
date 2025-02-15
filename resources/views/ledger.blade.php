@extends('layout')

@section('content')



    <div class="mt-5 card">
        <h2 class="card-header">Account Ledger</h2>
        <div class="card-body">


            <!-- Example Filtering Form (placed at the top of your view) -->
            <form method="GET" action="{{ route('transactions.filter') }}" class="mb-4">
                <div class="row">
                    <!-- Account Head Dropdown -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="account_head">Account Head</label>
                            <select name="account_head" id="account_head" class="form-control">
                                <option value="">-- Select Account Head --</option>
                                @foreach ($accountHeads as $accountHead)
                                    <option value="{{ $accountHead->id }}"
                                        {{ request('account_head') == $accountHead->id ? 'selected' : '' }}>
                                        {{ $accountHead->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- From Date Input -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>
                    </div>

                    <!-- To Date Input -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-2 align-self-end">
                        <button type="submit" class="mt-2 btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>


            @session('success')
                <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession

            <table class="table mt-4 table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Voucher</th>
                        <th>Notes</th>
                        <th>Account Head</th>
                        <th>Credit</th>
                        <th>Debit</th>
                    </tr>
                </thead>

                <tbody>


                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td><a
                                    href="{{ route('voucherfilter', ['voucher_id' => $transaction->voucher_id]) }}">{{ $transaction->voucherNumber->voucher_no }}</a>
                            </td>
                            <td>{{ $transaction->notes }}</td>
                            <td>{{ $transaction->head }}</td>
                            <td>{{ $transaction->debitAccountHead->name == 'Bank' || $transaction->debitAccountHead->name == 'Cash' ? '-' : $transaction->amount }}
                            </td>
                            <td>{{ $transaction->creditAccountHead->name == 'Bank' || $transaction->creditAccountHead->name == 'Cash' ? '-' : $transaction->amount }}
                            </td>

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
