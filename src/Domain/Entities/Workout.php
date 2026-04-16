<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Domain\Entities;

class Workout
{
    private ?int $completed = null;

    public function __construct(
        private readonly int $actionId,
        private readonly int $count
    )
    {
    }

    public function getActionId(): int
    {
        return $this->actionId;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function completed(int $count): void
    {
        $this->completed = $count;
    }

    public function getCompleted(): ?int
    {
        return $this->completed;
    }
}
