<?php

namespace App\Modules\Transactions\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Modules\AccountHeads\Models\AccountHead;
use App\Modules\Transactions\Models\Transaction;
use App\Modules\Vouchers\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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

        foreach ($transactions as $transaction) {
            if (($transaction->creditAccountHead->name == "Bank" || $transaction->creditAccountHead->name == "Cash")) {
                $transaction->method = $transaction->creditAccountHead->name;
            } elseif (($transaction->debitAccountHead->name == "Bank" || $transaction->debitAccountHead->name == "Cash")) {
                $transaction->method = $transaction->debitAccountHead->name;
            } else {
                $transaction->method = '-';
            }
        }

        $creditedcash = Transaction::whereHas('creditCash', function ($query) {
            $query->where('slug', 'cash');
        })
            ->whereYear('transaction_date', Carbon::now()->year)
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $debitedcash = Transaction::whereHas('debitCash', function ($query) {
            $query->where('slug', 'cash');
        })
            ->whereYear('transaction_date', Carbon::now()->year)
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->where('user_id', Auth::user()->id)
            ->sum('amount');
            
        $creditedBank = Transaction::whereHas('creditBank', function ($query) {
            $query->where('slug', 'bank');
        })
            ->whereYear('transaction_date', Carbon::now()->year)
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->where('user_id', Auth::user()->id)
            ->sum('amount');
        
        $debitedBank = Transaction::whereHas('debitBank', function ($query) {
            $query->where('slug', 'bank');
        })
            ->whereYear('transaction_date', Carbon::now()->year)
            ->whereMonth('transaction_date', Carbon::now()->month)
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $total_income = $creditedcash + $creditedBank;
        
        $total_expense = $debitedcash + $debitedBank;


        $credit_Cash = Transaction::whereHas('creditCash', function ($query) {
            $query->where('slug', 'cash');
        })
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $debit_Cash = Transaction::whereHas('debitCash', function ($query) {
            $query->where('slug', 'cash');
        })
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $cashHand = $credit_Cash - $debit_Cash;

        $credit_Bank = Transaction::whereHas('creditBank', function ($query) {
            $query->where('slug', 'bank');
        })
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $debit_Bank = Transaction::whereHas('debitBank', function ($query) {
            $query->where('slug', 'bank');
        })
            ->where('user_id', Auth::user()->id)
            ->sum('amount');

        $cashBank = $credit_Bank - $debit_Bank;
          // dd($transactions);

        $results = AccountHead::select('account_head.name as names')
          ->selectRaw('SUM(transactions.amount) as total_amount')
          ->join('transactions', function($join) {
              $join->on('transactions.credit_id', '=', 'account_head.id')
                   ->orOn('transactions.debit_id', '=', 'account_head.id');
            })
          ->where('transactions.user_id', '=',Auth::user()->id)
          ->where('account_head.name', '!=', 'Cash')
          ->where('account_head.name', '!=', 'Bank')
          ->groupBy('account_head.name')
          ->get();
        
        // dd($results);
        $chartData = "";

        foreach ($results as $result) {

            $chartData .= "['" . addslashes($result->names) . "', " . $result->total_amount . "],";
        }

        $chartData = rtrim($chartData, ",") ;

        return view('Transactions::transactions.index', compact('transactions', 'cashHand', 'cashBank', 'total_income', 'total_expense', 'chartData'));
    }

      /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Transactions::transactions.create');
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
                'voucher_no'  => $voucherNumber,
                'vocher_date' => $request->transaction_date,
                'user_id'     => Auth::user()->id,
            ]);
            foreach ($request->is_income as $index => $isIncome) {
                $creditId = $isIncome ? $request->payment_method_id[$index] : $request->account_head[$index];
                $debitId  = $isIncome ? $request->account_head[$index] : $request->payment_method_id[$index];



                Transaction::create([
                    'voucher_id'       => $voucher->id,
                    'credit_id'        => $creditId,
                    'debit_id'         => $debitId,
                    'amount'           => $request->amount[$index],
                    'notes'            => $request->notes[$index],
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
