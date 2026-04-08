<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Entities;

use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use Faker\Generator;
use N0mercy\TrainingPackage\Tests\TestCase;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;

class WorkoutTest extends TestCase
{
    private Generator $faker;
    private Workout $workout;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = FakerTool::faker();
        $this->workout = (new WorkoutFactory())->create(
            $this->faker->numberBetween(1, 10)
        );
    }

    public function testWorkoutInTrainingPlanCompleted(): void
    {
        // arr
        $workout = $this->workout;
        $initCount = $workout->getCount();
        $count = $this->faker->numberBetween(4, 15);

        // act
        $workout->completed($count);

        // ass
        $this->assertNull($initCount);
        $this->assertEquals(
            $count,
            $workout->getCount()
        );
    }

}
