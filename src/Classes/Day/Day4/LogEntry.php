<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class LogEntry
{
    public const TYPE_START_OF_SHIFT = 'start';
    public const TYPE_AWAKE = 'awake';
    public const TYPE_ASLEEP = 'asleep';

    /**
     * @var \DateTime
     */
    private $date;
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $guard;

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getDay(): string
    {
        return $this->getDate()->format('Y-m-d');
    }

    public function getTimestamp(): int
    {
        return $this->getDate()->getTimestamp();
    }

    public function getMinutes(): int
    {
        return (int) $this->getDate()->format('i');
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isStartOfShift(): bool
    {
        return $this->getType() === self::TYPE_START_OF_SHIFT;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function parseEntry(string $entry)
    {
        if (preg_match('/\[(.*)\]\s(.*)/', $entry, $matches)) {
            $this->setDate(new \DateTime($matches[1]));
            $this->parseType($matches[2]);
        }
    }

    private function parseType(string $description): void
    {
        if ($description === 'wakes up') {
            $this->setType(self::TYPE_AWAKE);
        } elseif ($description === 'falls asleep') {
            $this->setType(self::TYPE_ASLEEP);
        } elseif (preg_match('/Guard #(\d*) begins shift/', $description, $matches)) {
            $this->setType(self::TYPE_START_OF_SHIFT);
            $this->setGuard((int) $matches[1]);
        }
    }

    private function setGuard($guard)
    {
        $this->guard = $guard;
    }

    public function getGuard(): int
    {
        return $this->guard;
    }
}
