<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'note' => $this->note,
            'date_of_birth' => $this->date_of_birth,
            'url_web_page' => $this->url_web_page,
            'work_company' => $this->work_company,
            'phones' => $this->phones,
            'emails' => $this->emails,
            'addresses' => $this->addresses,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
