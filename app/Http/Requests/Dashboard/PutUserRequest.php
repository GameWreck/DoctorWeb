<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class PutUserRequest extends FormRequest
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
    {  $request=Request::only('id');
        return [
            'name' => 'required|min:3|max:20',
            'email' => ['required','email',Rule::unique('users')->ignore($request['id'])],
            'password' => 'nullable|min:8|max:20|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirmpassword'=>'nullable|min:8|max:20|required_with:password|same:password'
        ];
    }

    public function messages():array
    {  
         return [
            'password.regex'=>'Password is not strong enough eg:Admin@4427'
        ];
    }
}
