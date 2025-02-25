<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Car;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Car>
 */
final class CarFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Car::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'customer' => CustomerFactory::new(),
            'model' => ModelFactory::new(),
        ];
    }
}
