<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactoryInterface;
use Faker\Generator;
use N0mercy\TrainingPackage\Tests\TestCase;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;

class WorkoutFactoryTest extends TestCase
{
    private Generator $faker;
    private WorkoutFactory|WorkoutFactoryInterface $workoutFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = FakerTool::faker();
        $this->workoutFactory = new WorkoutFactory();
    }

    public function testCreate(): void
    {
        // arr
        $actionId = $this->faker->numberBetween(1, 10);

        // act
        $workout = $this->workoutFactory->create($actionId);

        // ass
        $this->assertEquals($actionId, $workout->getActionId());
    }
}
