<?php

namespace App\Http\Resources\Categories;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $backgrounds = [
            '#ff5c1e',
            '#5c9a3c',
            '#d03e3e',
            '#8b5002',
            '#86a8b1',
            '#b1aa5d',
            '#756d0d',
            '#903723',
            '#ada139'
        ];
        $data = parent::toArray($request);
        $data['bg'] = $backgrounds[array_rand($backgrounds)];
        $data['c_articles'] = $this->articles->count();
        return $data;
    }
}
