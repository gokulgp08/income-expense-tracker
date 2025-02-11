@extends('AccountHeads.layout')
   
@section('content')
  
<div class="mt-5 card">
  <h2 class="card-header">Account Head Index</h2>
  <div class="card-body">
          
        @session('success')
            <div class="alert alert-success" role="alert"> {{ $value }} </div>
        @endsession
  
        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
            <a class="btn btn-success btn-sm" href="{{ route('AccountHeads.create') }}"> <i class="fa fa-plus"></i> Create New Account Head</a>
        </div>
  
        <table class="table mt-4 table-bordered table-striped">
            <thead>
                <tr>
                    <th width="80px">No</th>
                    <th>Name</th>
                    <th>Slug</th>
                </tr>
            </thead>
  
            <tbody>

                
            @foreach ($accountHeads as $accountHead)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $accountHead->name }}</td>
                    <td>{{ $accountHead->slug }}</td>
                </tr>
            @endforeach
            </tbody>
  
        </table>
        
        {!! $accountHeads->links() !!}
  
  </div>
</div>  
@endsection