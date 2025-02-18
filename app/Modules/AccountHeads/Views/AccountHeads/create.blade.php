@extends('AccountHeads.layout')
    
@section('content')
  
<div class="mt-5 card">
  <h2 class="card-header">Add New Account Head</h2>
  <div class="card-body">
  
    <div class="gap-2 d-grid d-md-flex justify-content-md-end">
        <a class="btn btn-primary btn-sm" href="{{ route('transactions.create') }}"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
  
    <form action="{{ route('AccountHeads.store') }}" method="POST">
        @csrf
  
        <div class="mb-3">
            <label for="inputName" class="form-label"><strong>Name:</strong></label>
            <input 
                type="text" 
                name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                id="inputName" 
                placeholder="Name">
            @error('name')
                <div class="form-text text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
    </form>
  
  </div>
</div>
@endsection