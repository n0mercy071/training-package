<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Entities\Workout;

interface WorkoutFactoryInterface
{
    public function create(int $actionId): Workout;
}
