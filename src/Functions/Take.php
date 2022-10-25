<?php

namespace j45l\functional;

/**
 * @param mixed $target
 * @param int|string|array<string|int> $propertyName
 * @param mixed|null $defaultValue
 * @return mixed|null
 */
function take(mixed $target, array|int|string $propertyName, mixed $defaultValue = null): mixed
{
    $takeValue = static function ($target, $propertyName, $defaultValue) {
        return match (true) {
            is_object($target) && method_exists($target, $propertyName) =>
                $target->$propertyName() ?? $defaultValue,
            is_object($target) =>
                $target->$propertyName ?? $defaultValue,
            is_array($target) =>
                $target[$propertyName] ?? $defaultValue,
            default =>
                $defaultValue,
        };
    };

    return match (true) {
        !is_array($propertyName) =>
            $takeValue($target, $propertyName, $defaultValue),
        count($propertyName) === 0 =>
            $defaultValue,
        count($propertyName) === 1 =>
            take($target, first($propertyName), $defaultValue),
        default =>
            take(
                take($target, array_slice($propertyName, 0, -1)[0], $defaultValue),
                array_slice($propertyName, -1),
                $defaultValue
            ),
    };
}
