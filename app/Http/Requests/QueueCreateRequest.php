<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueueCreateRequest extends FormRequest
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
        $rules = [
            'queuedate' => 'required',
            'queuetime' => 'required',
            'service' => 'required',
            'shop' => 'required',
            'barber' => 'required',
            'name' => 'required',
            'phoneno' => 'required',
            'mailid' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            //
        ];
    }
}
