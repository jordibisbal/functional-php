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
            case is_object($target) && method_exists($target, $propertyName):
                return $target->$propertyName() ?? $defaultValue;
            case is_object($target):
                return $target->$propertyName ?? $defaultValue;
            case is_array($target):
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
            return take($target, $propertyName[0], $defaultValue);
        default:
            return take(
                take($target, array_slice($propertyName, 0, -1)[0], $defaultValue),
                array_slice($propertyName, -1),
                $defaultValue
            );
    }
}
