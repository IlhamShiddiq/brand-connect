<?php

namespace App\Http\Resources\Outlet;

use App\Helpers\OutletHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OutletNearestResource extends JsonResource
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
            'brand_name' => $this->brand->name,
            'name' => $this->name,
            'phone_number' => $this->phone_number,
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location_distance' => OutletHelper::convertOutletDistance($this->distance)
        ];
    }
}
