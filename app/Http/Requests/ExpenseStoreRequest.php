<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
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
            //
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'date_of_purchase' => date('Y-m-d 00:00:00', strtotime($this->date_of_purchase)),
            'date_purchase_belongs' => date('Y-m-d', strtotime($this->date_purchase_belongs)),
            'amount' => intval($this->amount*100),
        ]);
    }
}
