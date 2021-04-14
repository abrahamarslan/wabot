<?php

namespace App\Http\Requests\sequence;

use Illuminate\Foundation\Http\FormRequest;

class SequenceStoreRequest extends FormRequest
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
            'title'             =>      'required',
            'campaign_id'       =>      'required',
            'status'            =>      'required',
            'order'             =>      'required',
            'body'              =>      'required',
            'options'           =>      'required_with:hasOptions,1',
        ];
    }
}
