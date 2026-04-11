<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Repository;

interface WorkoutActionRepositoryInterface
{
    public function exists(int $actionId): bool;

    public function getMaxId(): ?int;

    public function getTableName(): string;

    public function getName(int $actionId): string;
}
