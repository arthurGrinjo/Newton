<?php

namespace App\Factory;

use App\Entity\SparePart;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<SparePart>
 */
final class SparePartFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return SparePart::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->firstName(),
            'price' => self::faker()->numberBetween(10, 100000),
        ];
    }
}
