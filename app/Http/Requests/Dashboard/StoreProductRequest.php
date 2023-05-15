<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','min:3','max:50'],
            'quantity'=> ['required','numeric','integer'],
            'brand' => ['required','string','min:3','max:50'],
            'model' => ['required','string','min:3','max:50'],
            'category'=> ['required','string','min:3','max:50'],
            'stock' => ['required','string', Rule::notIn(['select']),Rule::in(['instock','outofstock'])],
            'price'=>['required'],
            'image'=>['nullable','image']
        ];
    }
}
