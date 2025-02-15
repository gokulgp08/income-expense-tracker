<?php

namespace App\Http\Controllers;

use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['creditAccountHead', 'debitAccountHead', 'voucherNumber'])
        ->where('user_id', Auth::user()->id)
        ->latest()->paginate(100);

        foreach($transactions as $transaction){
            if(($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash" )){
                $transaction->method =  $transaction->creditAccountHead->name;

            }elseif(($transaction->debitAccountHead->name== "Bank" || $transaction->debitAccountHead->name== "Cash")){
                $transaction->method = $transaction->debitAccountHead->name;
            }else{
                $transaction->method  = '-';
            }
            
        }

        foreach($transactions as $transaction){
            if(($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash" )){
                $transaction->head =  $transaction->debitAccountHead->name;
                $transaction->transfer = 'Income';

            }elseif(($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")){
                $transaction->head = $transaction->creditAccountHead->name;
                $transaction->transfer = 'Expense';
            }else{
                $transaction->head  = '-';
            }
            
        }

        foreach($transactions as $transaction){
            if($transaction->voucherNumber->status == 1){
                $transaction->status = 'Active';
            }else{
                $transaction->status = 'Cancelled';
            }
        }

        return view('history', compact('transactions'))
                    ->with('i', (request()->input('page', 1) - 1) * 100);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction $transaction)
    {
        //
    }
}
