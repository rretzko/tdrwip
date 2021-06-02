<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnsembleRequest extends FormRequest
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
            'abbr' => ['string', 'required','max:8',],
            'descr' => 'nullable',
            'ensembletype_id' => ['numeric', 'required',],
            'gradetypes' => ['array', 'required', 'min:1'],
            'name' => ['string', 'required','max:40',],
            'startyear' => ['nullable','numeric','min:1700',],
        ];
    }

    public function messages()
    {
        return [
            'gradetypes.array' => 'Grades must be submitted as an array.',
            'gradetypes.required' => 'At least one grade must be checked.',
            'startyear.numeric' => 'The year of inception must be numeric.',
            'startyear.min' => 'The year of inception must be later than 1700.',
            ];
    }
}
