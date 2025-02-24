<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\MaintenanceJob;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<MaintenanceJob>
 */
final class MaintenanceJobFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return MaintenanceJob::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'task' => self::faker()->text(100),
            'duration' => self::faker()->numberBetween(0, 32),
        ];
    }
}
