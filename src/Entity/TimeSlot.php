<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\IdentifiableEntity;
use App\Repository\TimeSlotRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Uid\Uuid;

/**
 * TimeSlot is measured in quarters. There are 8h * 4 = 32 quarters per day.
 * There is no start and end-time, but the number gives an approximate time
 * from the moment the engineer starts his day.
 */
#[Entity(repositoryClass: TimeSlotRepository::class)]
class TimeSlot implements EntityInterface
{
    use IdentifiableEntity;

    #[Column(type: Types::DATE_IMMUTABLE)]
    private DateTimeImmutable $date;

    #[Column(type: Types::INTEGER, length: 2, nullable: false)]
    private int $start;

    #[Column(type: Types::INTEGER, length: 2, nullable: false)]
    private int $end;

    public function __construct(
        DateTimeImmutable $date,
        int $start,
        int $end,
    )
    {
        $this->uuid = Uuid::v6();
        $this
            ->setDate($date)
            ->setStart($start)
            ->setEnd($end)
        ;
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(DateTimeImmutable $date): self
    {
        $this->date = $date;
        return $this;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;
        return $this;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function setEnd(int $end): self
    {
        $this->end = $end;
        return $this;
    }

    public function getDuration(): int
    {
        return (int) $this->getEnd() - $this->getStart();
    }
}