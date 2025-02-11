<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        // dd($this->all());
        return [
        //    echo 1;
            'is_income' => 'required',
            'account_head' => 'required|exists:account_head,id',
            'payment_method_id' => 'required|exists:account_head,id',
            'amount' => 'required|numeric|min:0',
            'notes' => 'required|string',
            'transaction_date' => 'required',
            // 'user_id' => 'required|exists:users,id'-


        ];
    }
}
