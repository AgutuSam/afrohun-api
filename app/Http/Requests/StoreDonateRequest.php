<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDonateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
        
        'donation_type'=>['required', Rule::in(['skill', 'resource', 'cash', 'health services'])],
        'title'=>['required'],
        'description'=>['required'],
        'status' => ['required'],
        'amount'=>['required'],
        ];
    }
}
