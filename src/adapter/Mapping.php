<?php

namespace UniMapper\Flexibee\Adapter;

use UniMapper\Reflection;

class Mapping extends \UniMapper\Adapter\Mapping
{

    const DATETIME_FORMAT = "Y-m-d\TH:i:sP";

    public function mapValue(Reflection\Property $property, $value)
    {
        if ($property->isAssociation()
            && $property->getAssociation() instanceof Reflection\Association\ManyToOne
            && !empty($value)
        ) {
            return $value[0];
        }

        return $value;
    }

    public function unmapValue(Reflection\Property $property, $value)
    {
        if ($value === null) {
            return "";
        } elseif ($value instanceof \DateTime) {

            $value = $value->format(self::DATETIME_FORMAT);
            if ($value === false) {
                throw new \Exception("Can not convert DateTime automatically!");
            }
        }

        return $value;
    }

}