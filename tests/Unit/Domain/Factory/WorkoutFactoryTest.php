<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;

class WorkoutFactoryTest extends TestCase
{
    private WorkoutFactory|WorkoutFactoryInterface $workoutFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->workoutFactory = new WorkoutFactory();
    }

    public function testCreate(): void
    {
        // arr
        $actionId = $this->faker->numberBetween(1, 10);
        $count = $this->faker->numberBetween(4, 20);

        // act
        $workout = $this->workoutFactory->create($actionId, $count);

        // ass
        $this->assertEquals($actionId, $workout->getActionId());
        $this->assertEquals($count, $workout->getCount());
    }
}
