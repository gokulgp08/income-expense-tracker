@extends('layout')

@section('content')



    <div class="mt-5 card">
        <h2 class="card-header">Monthly Report</h2>
        <div class="card-body">

            <!-- Example Filtering Form (placed at the top of your view) -->
            <form method="GET" action="{{ route('reportfilter') }}" class="mb-4">
                <a href="{{ route('report.pdf', request()->query()) }}" class="btn btn-danger" style= "width: 120px; text-align: center;">Download as PDF</a>
                <a href="{{ route('report.excel', request()->query()) }}" class="btn btn-success" style= "width: 120px; text-align: center;">Download as Excel</a>
                <div class="row">

                    <!-- Account Head Dropdown -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="account_head">Choose One</label>
                            <select name="account_head" id="account_head" class="form-control">
                                <option value="">-- Select --</option>
                                <option value="1" {{ request('account_head') == '1' ? 'selected' : '' }}>Income
                                </option>
                                <option value="2" {{ request('account_head') == '2' ? 'selected' : '' }}>Expense
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Year Dropdown -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="year">Year</label>
                            <select name="year" id="year" class="form-control">
                                <option value="">-- Select --</option>
                                @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Month Dropdown -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="month">Month</label>
                            <select name="month" id="month" class="form-control">
                                <option value="">-- Select --</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                        {{ request('month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
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
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Voucher Number</th>
                        <th colspan="2" style="text-align: center;">Cash</th>
                        <th colspan="2" style="text-align: center;">Bank</th>
                        <th rowspan="2">Income/Expense</th>
                    </tr>
                    <tr>
                        <th>Credit</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Debit</th>
                    </tr>
                </thead>

                <tbody>


                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->transaction_date }}</td>
                            <td>{{ $transaction->voucherNumber->voucher_no }}</td>
                            <td>{{ $transaction->cashcreditamount }}</td>
                            <td>{{ $transaction->cashdebitamount }}</td>
                            <td>{{ $transaction->bankcreditamount }}</td>
                            <td>{{ $transaction->bankdebitamount }}</td>
                            <td>{{ $transaction->head }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
@endsection
