@extends('transactions.layout')
    
@section('content')
  
<div class="mt-5 card">
  <h2 class="card-header">Add New Transaction</h2>
  <div class="card-body">
  
    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('transactions.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    {{-- <form action="{{route('transactions.store')}}" method="POST"> --}}
        <form action="{{route('transactions.store')}}" method="POST" onsubmit="console.log('Form submitted');">

        @csrf

        <!-- Transaction Type: Income or Expense -->
        <div class="mb-3">
            <label class="form-label"><strong>Type:</strong></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_income" id="income" value="1" checked>
                    <label class="form-check-label" for="income">Income</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is_income" id="expense" value="0">
                    <label class="form-check-label" for="expense">Expense</label>
                </div>
            </div>
        </div>

        <!-- Account Head with Create Button -->
        <div class="mb-3">
            <label for="accountHead" class="form-label"><strong>Account Head:</strong></label>
            <div class="input-group">
                <select class="form-select" name="account_head" id="accountHead">
                    <option selected disabled>Choose Account Head</option>
                </select>
                <a class="btn btn-success btn-sm" href="{{ route('AccountHeads.create') }}"> <i class="fa fa-plus"></i> Create New</a>
            </div>
            @error('account_head')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
            <label for="paymentMethod" class="form-label"><strong>Payment Method:</strong></label>
            <select class="form-select" name="payment_method_id" id="paymentMethod" >
                <option selected disabled>Choose Payment Method</option>
            </select>
            @error('payment_method_id')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label"><strong>Amount:</strong></label>
            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
            @error('amount')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label for="notes" class="form-label"><strong>Notes:</strong></label>
            <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter Notes">
            @error('notes')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror  
    </div>

        <!-- Duplicate Entry Button -->
        <div class="mb-3">
            <button type="button" class="btn btn-outline-primary" id="duplicateForm">
                <i class="fa fa-clone"></i> Add More
            </button>
        </div>

        <!-- Date Field -->
        <div class="mb-3">
            <label for="transactionDate" class="form-label"><strong>Date:</strong></label>
            <input type="date" name="transaction_date" class="form-control" id="transactionDate">
            @error('transaction_date')
            <div class="form-text text-danger">{{ $message }}</div>
        @enderror  
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>
  
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('accountList') }}",
            type: "GET",
            success: function(response) {
                if(response.status) {
                    let options = '<option selected disabled>Choose Account Head</option>';
                    $.each(response.data, function(index, account) {
                        options += `<option value="${account.id}">${account.name}</option>`;
                    });
                    $("#accountHead").html(options);
                } else {
                    alert("No account head found!");
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('paymentMethod') }}",
            type: "GET",
            success: function(response) {
                if(response.status) {
                    let options = '<option selected disabled>Choose Payment Method</option>';
                    $.each(response.data, function(index, method) {
                        options += `<option value="${method.id}">${method.name}</option>`;
                    });
                    $("#paymentMethod").html(options);
                } else {
                    alert("No payment methods found!");
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    });

</script>
@endsection
