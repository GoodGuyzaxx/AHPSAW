<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AlternativeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id' => 'required|string',
            'criteria_id' => 'required|array',
            'criteria_id.*' => 'required|exists:criterias,id',
            'criteria_subs' => 'required|array',
            'criteria_subs.*' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $parts = explode('|', $value);
                    if (count($parts) !== 2) {
                        $fail($attribute . ' is invalid.');
                    } else {
                        $criteriaSubId = $parts[0];
                        $alternativeValue = $parts[1];
                        if (empty($criteriaSubId) || empty($alternativeValue)) {
                            $fail($attribute . ' tidak boleh memiliki nilai kosong.');
                        }
                        if (!\DB::table('criteria_subs')->where('id', $criteriaSubId)->exists()) {
                            $fail('Sub kriteria yang dipilih tidak ada.');
                        }
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'criteria_id.required' => 'semua kriteria harus di isi.',
            'criteria_subs.required' => 'semua kriteria harus di isi.',
            'criteria_subs.*.required' => 'semua kriteria harus di isi.',
        ];
    }
}

//class AlternativeStoreRequest extends FormRequest
//{
//    /**
//     * Determine if the user is authorized to make this request.
//     *
//     * @return bool
//     */
//    public function authorize()
//    {
//        return true;
//    }
//
//    /**
//     * Get the validation rules that apply to the request.
//     *
//     * @return array<string, mixed>
//     */
//    public function rules()
//    {
//        return [
//            'student_id' => 'required|exists:students,id',
//            'criteria_id'       => 'required|array',
//            'criteria_subs' => 'required|array',
//            'criteria_subs.*' => 'required|string'
//            // 'kelas_id'       => 'required|exists:kelas,id',
//            //'alternative_value' => 'required|array'
//        ];
//    }
//}
