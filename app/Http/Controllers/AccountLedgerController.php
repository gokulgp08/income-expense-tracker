<?php

namespace App\Http\Controllers;

use App\Exports\TransactionledgerExport;
use App\Exports\TransactionsExport;
use App\Models\transaction;
use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AccountLedgerController extends Controller
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

        

        return view('ledger', compact('transactions','accountHeads'));
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

    public function filter(Request $request)
    {
        $query = Transaction::with(['creditAccountHead', 'debitAccountHead', 'voucherNumber'])
        ->where('user_id', Auth::user()->id);
    
        if ($request->filled('account_head')) {
            $accountHeadId = $request->account_head;

            $query->where(function ($q) use ($accountHeadId) {
                $q->where('credit_id', $accountHeadId)
                  ->orWhere('debit_id', $accountHeadId);
            });
        }
    
        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }
    
        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }
    
        $query->orderBy('transaction_date', 'desc');
    
        $transactions = $query->get();

        foreach($transactions as $transaction){

            if(($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash" )){
                $transaction->head =  $transaction->debitAccountHead->name;

            }elseif(($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")){
                $transaction->head = $transaction->creditAccountHead->name;
            }else{
                $transaction->head  = '-';
            }
            
        }
    
        $accountHeads = AccountHead::whereNotIn('slug', ['cash','bank'])
            ->select('id', 'name')
            ->where('user_id', Auth::user()->id)
            ->get();
    
        return view('ledger', compact('transactions', 'accountHeads'));
    }

    public function downloadPdf(Request $request)
    {
        // Fetch filtered transactions based on filters
        $transactions = $this->getFilteredTransactions($request);

        // Generate PDF
        $pdf = Pdf::loadView('ledger_pdf', compact('transactions'));
        return $pdf->download('Ledger_Report.pdf');
    }

    public function downloadExcel(Request $request)
    {
        // Fetch filtered transactions
        $transactions = $this->getFilteredTransactions($request);

        return Excel::download(new TransactionledgerExport($transactions), 'Ledger_Report.xlsx');
    }

    private function getFilteredTransactions(Request $request){

        $query = Transaction::with(['creditAccountHead', 'debitAccountHead', 'voucherNumber'])
        ->where('user_id', Auth::user()->id);
    
        if ($request->filled('account_head')) {
            $accountHeadId = $request->account_head;

            $query->where(function ($q) use ($accountHeadId) {
                $q->where('credit_id', $accountHeadId)
                  ->orWhere('debit_id', $accountHeadId);
            });
        }
    
        if ($request->filled('from_date')) {
            $query->whereDate('transaction_date', '>=', $request->from_date);
        }
    
        if ($request->filled('to_date')) {
            $query->whereDate('transaction_date', '<=', $request->to_date);
        }
    
        $query->orderBy('transaction_date', 'desc');
    
        $transactions = $query->get();

        foreach($transactions as $transaction){

            if(($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash" )){
                $transaction->head =  $transaction->debitAccountHead->name;

            }elseif(($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")){
                $transaction->head = $transaction->creditAccountHead->name;
            }else{
                $transaction->head  = '-';
            }
            
        }

        return $transactions;

    }
    
}
