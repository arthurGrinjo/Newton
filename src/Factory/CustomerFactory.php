<?php

namespace App\Factory;

use App\Entity\Customer;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Customer>
 */
final class CustomerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Customer::class;
    }

    /**
     * @return array<string,mixed>
     */
    protected function defaults(): array
    {
        return [
            'name' => self::faker()->name,
        ];
    }
}
