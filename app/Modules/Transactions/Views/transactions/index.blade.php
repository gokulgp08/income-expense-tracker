@extends('layout')

@section('content')


    <div class="mt-5 card">
        <h2 class="card-header">Income and Expense</h2>
        <div class="card-body">

            @session('success')
                <div class="alert alert-success" role="alert"> {{ $value }} </div>
            @endsession

            <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                <a class="btn btn-success btn-sm" href="{{ route('transactions.create') }}"> <i class="fa fa-plus"></i> Create
                    New</a>
            </div>

            <table class="table mt-4 table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Income</th>
                        <th colspan="2">Expense</th>

                    </tr>
                </thead>

                <tbody>


                    <tr>
                        <td>{{ $total_income }}</td>
                        <td>{{ $total_expense }}</td>
                    </tr>
                    <tr rowspan="2">
                        <th>Cash in Hand</th>
                        <th>Cash in Bank</th>

                    </tr>
                    <tr rowspan="2">

                        <td>{{ $cashHand }}</td>
                        <td>{{ $cashBank }}</td>
                    </tr>

                </tbody>

            </table>


        </div>
    </div>
    {{-- <pre>{{ $chartData }}</pre> --}}
    <div id="piechart" style="width: 900px; height: 500px;"></div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Amount'],
                @php echo $chartData @endphp
            ]);

            var options = {
                title: 'Income and Expense Distribution'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>

@endsection
