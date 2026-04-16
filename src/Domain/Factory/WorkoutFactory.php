<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Entities\Workout;

class WorkoutFactory implements WorkoutFactoryInterface
{
    public function create(int $actionId, int $count): Workout
    {
        return new Workout($actionId, $count);
    }
}
