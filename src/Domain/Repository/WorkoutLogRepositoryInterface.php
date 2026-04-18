<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Repository;

use N0mercy\TrainingPackage\Domain\Entities\Workout;

interface WorkoutLogRepositoryInterface
{
    public function save(Workout $workout): void;
}
