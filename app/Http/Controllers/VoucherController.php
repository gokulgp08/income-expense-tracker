<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with(['creditAccountHead', 'debitAccountHead','voucherNumber','user'])->get();

        return view('voucher', compact('transactions'));
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
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        //
    }

    public function voucherfilter(Request $request,$voucher_id){
        // dd($voucher_id);
        $query = Transaction::with(['creditAccountHead', 'debitAccountHead','voucherNumber','user']);

        // dd($query->toSql());

        $voucher_id = $request->route('voucher_id');

        $query->where('voucher_id', $voucher_id);

        // dd($query->toSql());

        $transactions = $query->get();

        return view('voucher', compact('transactions'));



    }
}
