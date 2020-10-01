<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                                => $this->id,
            'expense_name'                      => $this->expense_name,
            'amount'                            => number_format($this->amount/100, 2, '.', ''),
            'description'                       => $this->description,
            'date_of_purchase'                  => date('d-m-Y', strtotime($this->date_of_purchase)),
            'date_purchase_belongs'             => date('d-m-Y', strtotime($this->date_purchase_belongs)),
            'date_purchase_belongs_formated'    => date('M, Y', strtotime($this->date_purchase_belongs)),
        ];
    }
}
