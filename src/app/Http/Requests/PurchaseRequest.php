<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
        return [
            'payment_method' => 'required|in:konbini,credit_card',
            'postcode'       => 'required|string|max:8',
            'address'        => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in'       => '有効な支払い方法を選択してください',
            'postcode.required'       => '配送先が設定されていません。プロフィールから住所を登録してください',
            'address.required'        => '配送先が設定されていません。プロフィールから住所を登録してください',
        ];
    }
}

