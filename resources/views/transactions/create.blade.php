@extends('transactions.layout')
    
@section('content')
  
<div class="mt-5 card">
  <h2 class="card-header">Add New Transaction</h2>
  <div class="card-body">
  
    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('transactions.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <!-- Transaction Type: Income or Expense -->
        <div class="mb-3">
            <label class="form-label"><strong>Type:</strong></label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="transaction_type" id="income" value="income" checked>
                    <label class="form-check-label" for="income">Income</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="transaction_type" id="expense" value="expense">
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
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <a class="btn btn-success btn-sm" href="{{ route('transactions.index') }}"> <i class="fa fa-plus"></i> Create New</a>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="mb-3">
            <label for="paymentMethod" class="form-label"><strong>Payment Method:</strong></label>
            <select class="form-select" name="payment_method" id="paymentMethod">
                <option selected disabled>Choose Payment Method</option>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label"><strong>Amount:</strong></label>
            <input type="number" name="amount" class="form-control" id="amount" placeholder="Enter Amount">
        </div>

        <!-- Notes -->
        <div class="mb-3">
            <label for="notes" class="form-label"><strong>Notes:</strong></label>
            <input type="text" name="notes" class="form-control" id="notes" placeholder="Enter Notes">
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
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>
  
  </div>
</div>
@endsection
