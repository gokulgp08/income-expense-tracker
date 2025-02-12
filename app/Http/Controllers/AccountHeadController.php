<?php

namespace App\Http\Controllers;

use App\Models\AccountHead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $accountHeads = AccountHead::latest()->paginate(5);
          
        // return view('AccountHeads.index', compact('accountHeads'))
        //             ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AccountHeads.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        AccountHead::create($validated);

        return redirect()->route('transactions.create');


    }

    /**
     * Display the specified resource.
     */
    public function show(AccountHead $accountHead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountHead $accountHead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountHead $accountHead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountHead $accountHead)
    {
        //
    }

    public function accountList(Request $request)
    {
        try{
            $account= AccountHead::where('user_id',Auth::user()->id)->wherenotIn('slug',['cash','bank'])->select('id','name')->get();

            if(!$account){
                return response()->json(['status' => false,'message' => ' No account head fetched','data'=>[]],200);
            }
            return response()->json(['status' => true,'message' => 'account head fetched','data'=>$account],200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
    
        }
        
    }

    public function paymentMethod(Request $request)
    {
        try{
            $account= AccountHead::where('user_id',Auth::user()->id)->whereIn('slug',['cash','bank'])->select('id','name')->get();

            if(!$account){
                return response()->json(['status' => false,'message' => ' No payment method fetched','data'=>[]],200);
            }
            return response()->json(['status' => true,'message' => 'payment method fetched','data'=>$account],200);

        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
    
        }
        
    }
}
