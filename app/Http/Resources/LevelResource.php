<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LevelResource extends JsonResource
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
            'title' => $this->title,
            'text' => $this->text,
            'time' => $this->time,
            'character' => $this->character,
            'variant' => new VariantResource($this->variant),
            'hints' => HintResource::collection($this->hints),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
//        return parent::toArray($request);
    }
}
