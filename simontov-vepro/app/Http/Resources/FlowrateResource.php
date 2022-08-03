<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlowrateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mag_date' => $this->mag_date->isoFormat('LLL'),
            'flowrate' => $this->flowrate . ' ' . $this->unit_flowrate,
            'totalizer_1' => $this->totalizer_1 . ' ' . $this->unittotalizer,
            'totalizer_2' => $this->totalizer_2 . ' ' . $this->unittotalizer,
            'totalizer_3' => $this->totalizer_3 . ' ' . $this->unittotalizer,
            'analog_1' => $this->analog_1,
            'analog_2' => $this->analog_2,
            'status_battery' => $this->status_battery,
            'alarm' => $this->alarm,
            'file_name' => $this->file_name,
        ];
    }
}
