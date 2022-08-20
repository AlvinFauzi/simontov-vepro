<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FlowrateChartResource extends JsonResource
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
            'mag_date_chart' => $this->mag_date->format('Y-m-d H:i:s'),
            'mag_date' => $this->mag_date->isoFormat('LLL'),
            'flowrate' => $this->flowrate,
            'analog_1' => $this->analog_1,
            'analog_2' => $this->analog_2,
            'bin_alarm' => $this->bin_alarm,
            'timestamp' => $this->mag_date->timestamp,
        ];
    }
}
