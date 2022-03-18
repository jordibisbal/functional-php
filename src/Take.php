<?php

namespace j45l\functional;

/**
 * @param mixed $target
 * @param string|int|array<string|int> $propertyName
 * @param mixed $defaultValue
 * @return mixed|null
 */
function take($target, $propertyName, $defaultValue = null)
{
    $takeValue = function ($target, $propertyName, $defaultValue) {
        switch (true) {
            case is_object($target) && !is_array($propertyName):
                return $target->$propertyName ?? $defaultValue;
            case is_array($target) && !is_array($propertyName):
                return $target[$propertyName] ?? $defaultValue;
            default:
                return $defaultValue;
        }
    };

    switch (true) {
        case !is_array($propertyName):
            return $takeValue($target, $propertyName, $defaultValue);
        case count($propertyName) == 0:
            return $defaultValue;
        case count($propertyName) == 1:
            return $takeValue($target, $propertyName[0], $defaultValue);
        default:
            return take(
                take($target, array_slice($propertyName, 0, -1), $defaultValue),
                array_slice($propertyName, -1),
                $defaultValue
            );
    }
}
