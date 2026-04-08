<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Fixtures\Domain;

use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;

class WorkoutFixture
{
    public static function create(): Workout
    {
        $faker = FakerTool::faker();
        $factory = new WorkoutFactory();

        return $factory->create($faker->numberBetween(1, 1000));
    }
}
