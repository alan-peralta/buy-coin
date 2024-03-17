<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $return = [];

        foreach ($this->resource as $item) {
            $name = explode("/", $item['name']);
            $value = (int)preg_replace('/[^0-9]/', '', $item['bid']);
            $decimals = explode(".", $item['bid']);

            $return[] = [
                'from' => $item['code'],
                'to' => $item['codein'],
                'name' => reset($name),
                'value' => $value,
                'decimals' => strlen(end($decimals)),
                'value_formatted' => number_format($item['bid'], 2, ',', '.')
            ];

        }
        return $return;
    }
}
