<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MonthlyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['creditAccountHead', 'debitAccountHead','voucherNumber'])
        ->where('user_id', Auth::user()->id)
        ->get();

        foreach($transactions as $transaction){

            if($transaction->creditAccountHead->name == "Cash" ){

                $transaction->cashcreditamount = $transaction->amount;

            }
            else{

                $transaction->cashcreditamount = '-';
            }

            if($transaction->debitAccountHead->name == "Cash"){

                $transaction->cashdebitamount = $transaction->amount;
            }else{

                $transaction->cashdebitamount = '-';
            }
            
            if($transaction->debitAccountHead->name == "Bank"){

                $transaction->bankdebitamount = $transaction->amount;

            }
            else{

                $transaction->bankdebitamount  = '-';
            }
            
            if($transaction->creditAccountHead->name == "Bank"){

                $transaction->bankcreditamount = $transaction->amount;
            }else{

                $transaction->bankcreditamount = '-';
            }
        }

        foreach($transactions as $transaction){

            if(($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash" )){
                $transaction->head =  $transaction->debitAccountHead->name;

            }elseif(($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")){
                $transaction->head = $transaction->creditAccountHead->name;
            }else{
                $transaction->head  = '-';
            }
            
        }

        $accountHeads = AccountHead::wherenotIn('slug',['cash','bank'])->select('id','name')
        ->where('user_id', Auth::user()->id)
        ->get();

        return view('report', compact('transactions','accountHeads'));

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

    public function reportfilter(Request $request)
    {
        // dd(request()->all());
        $query = Transaction::with(['creditAccountHead', 'debitAccountHead', 'voucherNumber'])->where('user_id', Auth::user()->id);
    
        if ($request->filled('account_head')) {

            if($request->account_head == 1){

                $query->whereHas('creditAccountHead', function ($q) {
                    $q->where('name', 'Cash'); // Replace 'name' with the actual column and value you're filtering by
                })
                ->orWhereHas('creditAccountHead', function ($q) {
                    $q->where('name', 'Bank'); 
                });;
            }

            if($request->account_head == 2){

                $query->WhereHas('debitAccountHead', function ($q) {
                    $q->where('name', 'Bank'); 
                })
                ->orWhereHas('debitAccountHead', function ($q) {
                    $q->where('name', 'Cash'); 
                });;
            }
            
        }

        if ($request->filled('year')) {
            $query->whereYear('transaction_date', '=', $request->year);
            // dd($query->toSql());
        }
    
        if ($request->filled('month')) {
            $query->whereMonth('transaction_date', '=', $request->month);
        }
    
        $query->orderBy('transaction_date', 'desc');

        $transactions = $query->get();

        foreach($transactions as $transaction){

            if($transaction->creditAccountHead->name == "Cash" ){

                $transaction->cashcreditamount = $transaction->amount;

            }
            else{

                $transaction->cashcreditamount = '-';
            }

            if($transaction->debitAccountHead->name == "Cash"){

                $transaction->cashdebitamount = $transaction->amount;
            }else{

                $transaction->cashdebitamount = '-';
            }
            
            if($transaction->debitAccountHead->name == "Bank"){

                $transaction->bankdebitamount = $transaction->amount;

            }
            else{

                $transaction->bankdebitamount  = '-';
            }
            
            if($transaction->creditAccountHead->name == "Bank"){

                $transaction->bankcreditamount = $transaction->amount;
            }else{

                $transaction->bankcreditamount = '-';
            }
        }

        foreach($transactions as $transaction){

            if(($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash" )){
                $transaction->head =  $transaction->debitAccountHead->name;

            }elseif(($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")){
                $transaction->head = $transaction->creditAccountHead->name;
            }else{
                $transaction->head  = '-';
            }
            
        }


        return view('report', compact('transactions'));
    }
}
