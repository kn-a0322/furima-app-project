<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return  true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'category_ids' => 'required|array',//複数のカテゴリを選択できるようにarrayで指定
            'condition_id' => 'required|integer',//商品の状態を選択できるようにintegerで指定
            'price' => 'required|integer|min:0',                        
        ];
    }

    public function attributes() //attributeは属性を指定するためのメソッド
    {
        return [
            'name' => '商品名',
            'description' => '商品の説明',
            'image' => '商品画像',
            'category_ids' => 'カテゴリ',
            'condition_id' => '商品の状態',
            'price' => '販売価格',
        ];
    }
}
