<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait BaseEnum
{
    public static function asArray(): array
    {
        return array_column(self::cases(), 'value', 'name');
    }
    public static function values(): array
    {
        return array_values(self::asArray());
    }
    public static function keys(): array
    {
        return array_keys(self::asArray());
    }
    public static function toCollection(): Collection
    {
        $data  = self::asArray();
        $items = [];
        foreach($data as $key => $val){
            $items[] = [
                "key"    => $key,
                "value" => $val,
            ];
        }
        return collect($items);
    }
    public static function hasValue($value): bool
    {
        $validValues = self::values();
        return in_array($value, $validValues, true);
    }
    public static function key($value): bool|int|string
    {
        return array_search($value, self::asArray());
    }
    public function getLabel(): string
    {
        return  strtolower($this->name);
    }
}
