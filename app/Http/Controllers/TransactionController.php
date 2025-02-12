<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $transactions = Transaction::with(['creditAccountHead', 'debitAccountHead'])
        ->where('user_id', Auth::user()->id)
        ->get();
        
        return view('transactions.index', compact('transactions'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        // dd($request->all());
        try{
        if($request->is_income){
            $creditId = $request->payment_method_id;
            $debitId = $request->account_head;
        }else{
            $creditId = $request->account_head;
            $debitId = $request->payment_method_id;

        }
        $vochernumer  = rand(1000,999999);
       $voucher= Voucher::create([
            'voucher_no' => $vochernumer,
            'vocher_date' => $request->transaction_date,
            'user_id' => Auth::user()->id,
       ]);

       Transaction::create([
        'voucher_id' => $voucher->id,
        'credit_id' =>$creditId,
        'debit_id' => $debitId,
        'amount' => $request->amount,
        'notes' => $request->notes,
        'transaction_date' => $request->transaction_date

       ]);
       return redirect()->route('transactions.index');


       
    }catch(\Exception $e){
        return response()->json(['error' => $e->getMessage()], 400);

    }
        

    


        
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
