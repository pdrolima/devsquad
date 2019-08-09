<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:64',
                Rule::unique('products', 'name')->where(function ($query) {
                    $query->whereNull('deleted_at');
                })->ignore($this->product->id)
            ],
            'description' => 'required',
            'category' => 'required|exists:product_categories,id',
            'price' => 'required|integer',
        ];
    }
}
