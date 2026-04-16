<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Entities;

use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanIdNotPositive;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use Exception;
use N0mercy\TrainingPackage\Tests\TestCase;

class TrainingPlanTest extends TestCase
{
    private TrainingPlanFactoryInterface $trainingPlanFactory;
    private TrainingPlanRepositoryInterface $trainingPlanRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $workoutActionRepository = $this->createMock(WorkoutActionRepositoryInterface::class);
        $workoutActionRepository
            ->method('getMaxId')
            ->willReturn(1);
        $workoutActionRepository
            ->method('exists')
            ->willReturn(true);
        $this->trainingPlanFactory = new TrainingPlanFactory();
        $this->trainingPlanRepository = $this->createMock(TrainingPlanRepositoryInterface::class);
        $this->trainingPlanRepository
            ->method('getById')
            ->willReturn($this->createTrainingPlan());
    }

    /**
     * @throws Exception
     */
    public function testAddingWorkoutInTrainingPlan(): void
    {
        // arr
        $name = $this->faker->words(2, true);
        $workout = $this->createWorkout();

        // act
        $trainingPlan = $this->trainingPlanFactory->create(name: $name);
        $trainingPlan->addWorkout($workout);

        // ass
        $this->assertTrue(count($trainingPlan->getWorkouts()) === 1);
        $this->assertInstanceOf(Workout::class, $trainingPlan->getWorkouts()[0]);
    }

    public function testAddingWorkoutsInTrainingPlan(): void
    {
        // arr
        $name = $this->faker->words(2, true);
        $workouts = [];
        for ($i = 0; $i < $this->faker->numberBetween(3, 6); $i++) {
            $workouts[] = $this->createWorkout();
        }

        // act
        $trainingPlan = $this->trainingPlanFactory->create(name: $name);
        $trainingPlan->addWorkouts($workouts);

        // ass
        $this->assertTrue(count($trainingPlan->getWorkouts()) === count($workouts));
        $this->assertInstanceOf(Workout::class, $trainingPlan->getWorkouts()[0]);
    }

    /**
     * @throws TrainingPlanEmptyException
     */
    public function testWorkoutInTrainingPlanCompleted(): void
    {
        // arr
        $trainingPlan = $this->trainingPlanRepository->getById(
            $this->faker->numberBetween(1, 100),
            1
        );
        $count = $this->faker->numberBetween(4, 25);
        $workout = $trainingPlan->getCurrentWorkout();

        // act
        $workout->completed($count);
        $newWorkout = $trainingPlan->getCurrentWorkout();

        // ass
        $this->assertNotEquals($workout, $newWorkout);
    }

    /**
     * @throws TrainingPlanEmptyException
     */
    public function testTrainingPlanCompleted(): void
    {
        // arr
        $trainingPlan = $this->trainingPlanRepository->getById(
            $this->faker->numberBetween(1, 100),
            1
        );
        $workoutCount = $trainingPlan->getWorkoutCount();

        // act
        for ($i = 0; $i < $workoutCount; $i++) {
            $workout = $trainingPlan->getCurrentWorkout();
            $workout->completed($this->faker->numberBetween(4, 25));
        }
        $workoutCompletedCount = $trainingPlan->getWorkoutCompletedCount();
        $nullWorkout = $trainingPlan->getCurrentWorkout();

        // ass
        $this->assertEquals($workoutCount, $workoutCompletedCount);
        $this->assertNull($nullWorkout);
    }

    public function testGetCurrentWorkoutInEmptyTrainingPlan(): void
    {
        // arr
        $trainingPlan = $this->trainingPlanFactory->create(
            $this->faker->words(2, true),
        );

        // act
        $this->expectException(TrainingPlanEmptyException::class);
        $trainingPlan->getCurrentWorkout();

        // ass
    }

    /**
     * @throws TrainingPlanIdNotPositive
     */
    public function testSetIdInTrainingPlan(): void
    {
        // arr
        $id = $this->faker->numberBetween(1, 100);
        $trainingPlan = $this->trainingPlanFactory->create(
            $this->faker->words(2, true),
        );

        // act
        $trainingPlan->setId($id);

        // ass
        $this->assertEquals($id, $trainingPlan->getId());
    }

    public function testSetIdZeroInTrainingPlan(): void
    {
        // arr
        $id = $this->faker->numberBetween(-100, 0);
        $trainingPlan = $this->trainingPlanFactory->create(
            $this->faker->words(2, true),
        );

        // act
        $this->expectException(TrainingPlanIdNotPositive::class);
        $trainingPlan->setId($id);

        // ass
    }
}
