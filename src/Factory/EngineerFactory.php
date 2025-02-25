<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Engineer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Engineer>
 */
final class EngineerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Engineer::class;
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
