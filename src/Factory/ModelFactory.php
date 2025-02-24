<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Model;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Model>
 */
final class ModelFactory extends PersistentProxyObjectFactory
{

    public static function class(): string
    {
        return Model::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'brand' => BrandFactory::new(),
            'name' => self::faker()->firstName,
        ];
    }
}
