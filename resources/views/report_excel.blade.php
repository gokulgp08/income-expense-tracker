<!DOCTYPE html>
<html>

<head>
    <title>Monthly Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Monthly Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Voucher Number</th>
                <th>Cash Credit</th>
                <th>Cash Debit</th>
                <th>Bank Credit</th>
                <th>Bank Debit</th>
                <th>Income/Expense</th>
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

</body>

</html>
