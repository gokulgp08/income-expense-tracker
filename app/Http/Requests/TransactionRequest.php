<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Log::info('reqest');
        // dd(request()->all());
        return [
            'is_income' => 'required|array',
            'is_income.*' => 'required|boolean', // Validate each item in the array
            
            'account_head' => 'required|array',
            'account_head.*' => 'required|exists:account_head,id', 
            
            'payment_method_id' => 'required|array',
            'payment_method_id.*' => 'required|exists:account_head,id',
    
            'amount' => 'required|array',
            'amount.*' => 'required|numeric|min:0',
    
            'notes' => 'required|array',
            'notes.*' => 'required|string',
    
            'transaction_date' => 'required|date',
        ];
    }
    
}
