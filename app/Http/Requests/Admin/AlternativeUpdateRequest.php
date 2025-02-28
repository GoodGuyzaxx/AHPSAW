<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AlternativeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'alternative_id' => 'required|array',
            'alternative_id.*' => 'exists:alternatives,id',
            'criteria_id' => 'required|array',
            'criteria_id.*' => 'exists:criterias,id',
            'alternative_value' => 'required|array',
            'alternative_value.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value !== 'Empty') {
                        $parts = explode('|', $value);
                        if (count($parts) !== 2) {
                            $fail($attribute . ' is invalid.');
                        } else {
                            $criteriaSubId = $parts[0];
                            if (!\DB::table('criteria_subs')->where('id', $criteriaSubId)->exists()) {
                                $fail('The selected criteria sub does not exist.');
                            }
                        }
                    }
                },
            ],
        ];
    }
}

//class AlternativeUpdateRequest extends FormRequest
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
//        $rules = [
//            'criteria_id'       => 'required|array',
//            'alternative_id'    => 'required|array',
//            'alternative_value' => 'required|array',
//            'alternative_value.*' => 'required|string', // Format select option yang benar
//        ];
//
//        if ($this->input('new_student_id')) {
//            $rules['new_student_id']        = 'required|exists:students,id';
//            $rules['new_criteria_id']       = 'required|array';
//            $rules['new_kelas_id']          = 'required|exists:kelas,id';
//            $rules['new_alternative_value'] = 'required|array';
//            $rules['new_alternative_value.*'] = 'required|string'; // Format select option yang benar
//        }
//
//        return $rules;
//    }
//}
