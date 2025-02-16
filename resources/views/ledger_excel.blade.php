<!DOCTYPE html>
<html>

<head>
    <title>Ledger Report</title>
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
    <h2>Ledger Report</h2>
    <table>
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
                    <td>{{$transaction->voucherNumber->voucher_no}}</td>
                    <td>{{ $transaction->notes }}</td>
                    <td>{{ $transaction->head }}</td>
                    <td>{{ $transaction->debitAccountHead->name == 'Bank' || $transaction->debitAccountHead->name == 'Cash' ? '-' : $transaction->amount }}
                    </td>
                    <td>{{ $transaction->creditAccountHead->name == 'Bank' || $transaction->creditAccountHead->name == 'Cash' ? '-' : $transaction->amount }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
