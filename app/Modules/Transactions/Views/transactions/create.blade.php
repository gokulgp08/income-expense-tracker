@extends('layout')

@section('content')
    <div class="mt-5 card">
        <h2 class="card-header">Add New Transaction</h2>
        <div class="card-body">

            <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                <a class="btn btn-primary btn-sm" href="{{ route('transactions.index') }}"><i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" onsubmit="console.log('Form submitted');">
                @csrf

                <div class="transaction-entries">
                    <div class="transaction-entry">
                        <!-- Transaction Type -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Type:</strong></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_income[0]" value="1"
                                        checked>
                                    <label class="form-check-label">Income</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="is_income[0]" value="0">
                                    <label class="form-check-label">Expense</label>
                                </div>
                            </div>
                        </div>

                        <!-- Account Head -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Account Head:</strong></label>
                            <div class="input-group">
                                <select class="form-select" name="account_head[]">
                                    <option selected disabled>Choose Account Head</option>
                                </select>
                                <a class="btn btn-success btn-sm" href="{{ route('AccountHeads.create') }}">
                                    <i class="fa fa-plus"></i> Create New
                                </a>
                            </div>
                            @error('account_head')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Payment Method:</strong></label>
                            <select class="form-select" name="payment_method_id[]">
                                <option selected disabled>Choose Payment Method</option>
                            </select>
                            @error('payment_method_id')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Amount:</strong></label>
                            <input type="number" name="amount[]" class="form-control" placeholder="Enter Amount">
                            @error('amount')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label class="form-label"><strong>Notes:</strong></label>
                            <input type="text" name="notes[]" class="form-control" placeholder="Enter Notes">
                            @error('notes')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remove Button -->
                        <button type="button" class="btn btn-danger btn-sm remove-entry">
                            <i class="fa fa-trash"></i> Remove
                        </button>
                    </div>
                </div>

                <!-- Duplicate Entry Button -->
                <div class="mb-3">
                    <button type="button" class="btn btn-outline-primary" id="duplicateForm">
                        <i class="fa fa-clone"></i> Add More
                    </button>
                </div>

                <!-- Date (Global for all transactions) -->
                <div class="mb-3">
                    <label class="form-label"><strong>Date:</strong></label>
                    <input type="date" name="transaction_date" class="form-control">
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
            // Load Account Heads
            $.ajax({
                url: "{{ route('accountList') }}",
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        let options = '<option selected disabled>Choose Account Head</option>';
                        $.each(response.data, function(index, account) {
                            options += `<option value="${account.id}">${account.name}</option>`;
                        });
                        $("select[name='account_head[]']").html(options);
                    }
                }
            });

            // Load Payment Methods
            $.ajax({
                url: "{{ route('paymentMethod') }}",
                type: "GET",
                success: function(response) {
                    if (response.status) {
                        let options = '<option selected disabled>Choose Payment Method</option>';
                        $.each(response.data, function(index, method) {
                            options += `<option value="${method.id}">${method.name}</option>`;
                        });
                        $("select[name='payment_method_id[]']").html(options);
                    }
                }
            });

            // Duplicate Form Fields
            $("#duplicateForm").click(function() {
                let newEntry = $(".transaction-entry:first").clone();
                let index = $(".transaction-entry").length;

                // Clear text/number inputs and select values, but leave radio inputs untouched
                newEntry.find("input[type='text'], input[type='number'], select").val("");

                // Update radio button name attributes to include the new index
                newEntry.find("input[type='radio']").each(function() {
                    $(this).attr("name", "is_income[" + index + "]");
                });

                // Set the default selection for the duplicated entry.
                // If you want to default to Expense (value "0") change to:
                newEntry.find("input[type='radio'][value='0']").prop("checked", true);

                // Append the new entry
                $(".transaction-entries").append(newEntry);
            });

            // Remove Entry
            $(document).on("click", ".remove-entry", function() {
                if ($(".transaction-entry").length > 1) {
                    $(this).closest(".transaction-entry").remove();
                }
            });
        });
    </script>
@endsection
