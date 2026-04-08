<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Fixtures\Domain;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;

final class TrainingPlanFixture
{
    public static function createTrainingPlanWithWorkouts(): TrainingPlan
    {
        $faker = FakerTool::faker();

        $trainingPlan = (new TrainingPlanFactory())
            ->create($faker->words(2, true));

        for ($i = 0; $i < $faker->numberBetween(4, 6); $i++) {
            $trainingPlan->addWorkout(
                (new WorkoutFactory())->create($i + 1)
            );
        }

        return $trainingPlan;
    }
}
