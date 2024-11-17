<?php

namespace Vyuldashev\LaravelOpenApi\Concerns;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\CallbackFactory;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

trait Referencable
{
    static $buildInstances = [];

    public static function ref(?string $objectId = null): Schema
    {
        $instance = app(static::class);

        if (! $instance instanceof Reusable) {
            throw new InvalidArgumentException('"'.static::class.'" must implement "'.Reusable::class.'" in order to be referencable.');
        }

        $baseRef = null;

        if ($instance instanceof CallbackFactory) {
            $baseRef = '#/components/callbacks/';
        } elseif ($instance instanceof ParametersFactory) {
            $baseRef = '#/components/parameters/';
        } elseif ($instance instanceof RequestBodyFactory) {
            $baseRef = '#/components/requestBodies/';
        } elseif ($instance instanceof ResponseFactory) {
            $baseRef = '#/components/responses/';
        } elseif ($instance instanceof SchemaFactory) {
            $baseRef = '#/components/schemas/';
        } elseif ($instance instanceof SecuritySchemeFactory) {
            $baseRef = '#/components/securitySchemes/';
        }

        $buildInstance = null;

        // This form is used only temporary for tests
        if (array_key_exists(static::class, self::$buildInstances)) {
            ray('Build instance of ' . static::class . ' found');
            $buildInstance = self::$buildInstances[static::class];
        } else {
            ray('Building instance of ' . static::class);
            $buildInstance = $instance->build();
            self::$buildInstances[static::class] = $buildInstance;
        }

        // Could be replaced with this:
        // $buildInstance = $buildInstances[static::class] ??= $instance->build();

        return Schema::ref($baseRef . $buildInstance->objectId, $objectId);
    }
}
