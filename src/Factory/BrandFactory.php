<?php

namespace App\Factory;

use App\Entity\Brand;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Brand>
 */
final class BrandFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Brand::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->firstName,
        ];
    }
}
