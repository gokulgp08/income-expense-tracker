<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        foreach($transactions as $transaction){
            if(($transaction->creditAccountHead->name== "Bank" || $transaction->creditAccountHead->name== "Cash" )){
                $transaction->method =  $transaction->creditAccountHead->name;

            }elseif(($transaction->debitAccountHead->name== "Bank" || $transaction->debitAccountHead->name== "Cash")){
                $transaction->method = $transaction->debitAccountHead->name;
            }else{
                $transaction->method  = '-';
            }
            
        }

        
        


        $credit_Cash = Transaction::whereHas('creditCash', function($query) {
            $query->where('slug', 'cash');
        })
        ->where('user_id',Auth::user()->id)
        ->sum('amount');

        $debit_Cash = Transaction::whereHas('debitCash', function($query) {
            $query->where('slug', 'cash');
        })
        ->where('user_id',Auth::user()->id)
        ->sum('amount');

        $cashHand = $credit_Cash - $debit_Cash;

        $credit_Bank = Transaction::whereHas('creditBank', function($query) {
            $query->where('slug', 'bank');
        })
        ->where('user_id',Auth::user()->id)
        ->sum('amount');

        $debit_Bank = Transaction::whereHas('debitBank', function($query) {
            $query->where('slug', 'bank');
        })
        ->where('user_id',Auth::user()->id)
        ->sum('amount');

        $cashBank = $credit_Bank - $debit_Bank;
        // dd($transactions);

        return view('transactions.index', compact('transactions', 'cashHand', 'cashBank'));

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
        try {
            // Log::info('reqest');
            
            $voucherNumber = rand(1000, 999999);
    
            $voucher = Voucher::create([
                'voucher_no' => $voucherNumber,
                'vocher_date' => $request->transaction_date,
                'user_id' => Auth::user()->id,
            ]);
            foreach ($request->is_income as $index => $isIncome) {
                $creditId = $isIncome ? $request->payment_method_id[$index] : $request->account_head[$index];
                $debitId = $isIncome ? $request->account_head[$index] : $request->payment_method_id[$index];
    
                
    
                Transaction::create([
                    'voucher_id' => $voucher->id,
                    'credit_id' => $creditId,
                    'debit_id' => $debitId,
                    'amount' => $request->amount[$index],
                    'notes' => $request->notes[$index],
                    'transaction_date' => $request->transaction_date,
                ]);
            }
    
            return redirect()->route('transactions.index')->with('success', 'Transactions saved successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error saving transactions: ' . $e->getMessage());
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
