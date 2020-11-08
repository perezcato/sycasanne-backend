<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->LApplicIndex,
            'client_name' => $this->ClientName,
            'client_reference' => $this->ClientRef,
            'amount' => $this->Amt,
            'disbursement_date' => $this->ActualDisbursalDate,
            'tenor' => $this->Tenor,
            'loan_image' => $this->LoanImage ?: '',
            'mime' => $this->Mime?:''
        ];
    }
}
