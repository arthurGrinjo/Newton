<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityInterface;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @template E of EntityInterface
 */
trait EntityRepository
{
    /**
     * @return E|null
     * @throws InvalidArgumentException
     * @deprecated use getByUuid instead
     */
    public function findByUuid(Uuid|string $uuid)
    {
        if (!$uuid instanceof Uuid) {
            $uuid = Uuid::fromString($uuid);
        }

        /** @var E|null */
        return $this->findOneBy(['uuid' => $uuid->toRfc4122()]);
    }
}