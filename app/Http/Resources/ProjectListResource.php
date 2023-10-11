<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'user_id'       => $this->user_id,
            'project_id'    => $this->project_id,

            'title'         => $this->title,
            'description'   => $this->description,
            'icon'          => $this->icon,
            'color_hex'     => $this->color_hex,

            'items' => $this->items,
        ];

    }
}
