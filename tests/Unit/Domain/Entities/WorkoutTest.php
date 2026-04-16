<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Entities;

use N0mercy\TrainingPackage\Tests\TestCase;

class WorkoutTest extends TestCase
{

    public function testWorkoutInTrainingPlanCompleted(): void
    {
        // arr
        $workout = $this->createWorkout();
        $initCount = $workout->getCompleted();
        $count = $this->faker->numberBetween(4, 15);

        // act
        $workout->completed($count);

        // ass
        $this->assertNull($initCount);
        $this->assertEquals(
            $count,
            $workout->getCompleted()
        );
    }

}
