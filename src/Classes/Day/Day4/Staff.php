<?php declare(strict_types = 1);

namespace Sventendo\AdventOfCode2018\Day\Day4;

class Staff implements \Iterator
{
    /**
     * @var Guard[]
     */
    private $guards = [];

    private $index = 0;

    public function addGuard(Guard $guard): void
    {
        $this->guards[] = $guard;
    }

    public function hasGuard(int $id): bool
    {
        return !is_null($this->getGuardById($id));
    }

    public function getGuardById(int $id): ?Guard
    {
        $guard = null;
        $guards = array_filter(
            $this->guards,
            function (Guard $guard) use ($id) {
                return $guard->getId() === $id;
            }
        );
        if (\count($guards)) {
            $guard = reset($guards);
        }

        return $guard;
    }

    public function current()
    {
        return $this->guards[$this->index];
    }

    public function next()
    {
        $this->index++;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return array_key_exists($this->index, $this->guards);
    }

    public function rewind()
    {
        $this->index = 0;
    }
}
