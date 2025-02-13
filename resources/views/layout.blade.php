<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transactions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>
<body>
    <div class="container">

        <div style="display: flex; padding: 10px;">
            <a href="{{ route('transactions.index') }}" style="padding: 10px;">Dashboard</a>
            <a href="{{route('history')}}" style="padding: 10px;">History</a>
            <a href="{{route('ledger')}}"style="padding: 10px;">Ledger</a>
            <a href="{{route('voucher')}}" style="padding: 10px;">Voucher</a>
        
        </div>

        
        @yield('content')
    </div>
</body>
</html>