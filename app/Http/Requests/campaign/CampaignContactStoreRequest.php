<?php

namespace App\Http\Requests\campaign;

use Illuminate\Foundation\Http\FormRequest;

class CampaignContactStoreRequest extends FormRequest
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
            'file' => 'required|max:10000|mimes:xlsx'
        ];
    }
}
