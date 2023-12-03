<?php
namespace App\Constants\Product;

class ProductSpecificationConstants
{
    const TYPE = "TYPE";
    const BUILTIN_MEMORY = "BUILTIN_MEMORY";
    const RAM = "RAM";
    const COLOR = "COLOR";
    const BATTERY = "BATTERY";
    const SCREEN_RESOLUTION = "SCREEN_RESOLUTION";
    const PROCESSOR_CORES = "PROCESSOR_CORES";
    const MODEL = "MODEL";
    const MANUFACTURER_CODE = "MANUFACTURER_CODE";
    const PRODUCT_CODE = "PRODUCT_CODE";
    const CONNECTION_TYPE = "CONNECTION_TYPE";
    const DESIGN = "DESIGN";
    const CHARGING_CONNECTOR = "CHARGING_CONNECTOR";

    const LIST = [
        self::TYPE,
        self::BUILTIN_MEMORY,
        self::RAM,
        self::COLOR,
        self::BATTERY,
        self::SCREEN_RESOLUTION,
        self::PROCESSOR_CORES,
        self::MODEL,
        self::MANUFACTURER_CODE,
        self::PRODUCT_CODE,
        self::CONNECTION_TYPE,
        self::DESIGN,
        self::CHARGING_CONNECTOR,
    ];


    public static function getList()
    {
        $list = [];
        foreach (self::LIST as $value) {
            $list[$value] = self::getTitle($value);
        }

        return $list;
    }

    public static function getTitle($value)
    {
        return ucwords(strtolower(str_replace("_" , " " , $value)));
    }
}


