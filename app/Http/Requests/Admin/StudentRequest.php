<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'npm' => 'required|unique:students|min:3',
            'name' => 'required|max:60|min:5',
            'gender' => ['required', 'in:Laki-laki,Perempuan'],
            'nomor_hp' => 'required',
            'email' => 'required|email|unique:students,email',
        ];
    }
}
