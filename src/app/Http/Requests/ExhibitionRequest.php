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
            'image'        => 'required|image|mimes:jpeg,png',
            'category_ids' => 'required|array',
            'condition_id' => 'required|in:good,no_major_damage,slight_damage,poor',
            'name'         => 'required|string|max:255',
            'brand_name'   => 'nullable|string|max:255',
            'description'  => 'required|string|max:255',
            'price'        => 'required|integer|min:0',                        
        ];
    }

    public function messages() 
    {
        return [
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'description.string' => '商品の説明は文字列で入力してください。',
            'description.max' => '商品の説明は255文字以内で入力してください。',
            'image.required' => '商品画像を選択してください。',
            'image.mimes' => '商品画像はjpegまたはpngファイルを選択してください。',
            'category_ids.required' => 'カテゴリーを一つ以上選択してください。',
            'condition_id.required' => '商品の状態を選択してください。',
            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は整数で入力してください。',
            'price.min' => '販売価格は0以上で入力してください。',
        ];
    }       //messagesはバリデーションエラーメッセージを指定するためのメソッド
}
