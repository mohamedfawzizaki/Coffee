<?php

namespace App\Http\Resources\Mobile\General\WorkTime;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTimeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'day'  => $this->day,
            'from' => $this->from,
            'to'   => $this->to,
            'all_day' => $this->all_day,
        ];
    }
}
