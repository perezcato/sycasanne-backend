<?php

namespace App\Http\Resources\MobileBanker;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LoanResource extends JsonResource
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
            'loan_id' => $this->LApplicIndex,
            'client_name' => trim($this->ClientName),
            'client_reference' => $this->ClientRef,
            'loan_amount' => $this->Amt
        ];
    }
}
