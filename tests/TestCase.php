<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Tests;

require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Generator;
use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanIdNotPositive;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\WorkoutFactory;
use N0mercy\TrainingPackage\Domain\Repository\TrainingRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as BaseTestCase;


class TestCase extends BaseTestCase
{
    protected ?TrainingPlan $foundTrainingPlanTrainingRepository = null;
    protected Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = FakerTool::faker();
        $this->foundTrainingPlanTrainingRepository = null;
    }

    public function createWorkout(): Workout
    {
        return (new WorkoutFactory())->create(
            $this->faker->numberBetween(1, 100),
            $this->faker->numberBetween(4, 20)
        );
    }

    public function createTrainingPlan(): TrainingPlan
    {
        return (new TrainingPlanFactory())->create(
            $this->faker->words(2, true),
        );
    }

    public function createTrainingPlanWithWorkouts(): TrainingPlan
    {
        $plan = $this->createTrainingPlan();

        $plan->addWorkout($this->createWorkout());
        $plan->addWorkout($this->createWorkout());

        return $plan;
    }

    public function createMockTrainingRepository(): TrainingRepositoryInterface&MockObject
    {
        $repository = $this->createMock(TrainingRepositoryInterface::class);

        $repository->expects($this->any())
            ->method('find')
            ->willReturnCallback(
                fn(int $id, int $userId) => $this->findTrainingRepositoryMock($id, $userId)
            );

        $repository->expects($this->any())
            ->method('save')
            ->willReturnCallback(function (TrainingPlan $trainingPlan, int $userId) {
                if (is_null($trainingPlan->getId())) {
                    $trainingPlan->setId(1);
                }

                return $trainingPlan;
            });

        return $repository;
    }

    public function createMockWorkoutActionRepository(): WorkoutActionRepositoryInterface&MockObject
    {
        return $this->createMock(WorkoutActionRepositoryInterface::class);
    }

    /**
     * @throws TrainingPlanIdNotPositive
     */
    protected function findTrainingRepositoryMock(int $id, int $userId): ?TrainingPlan
    {
        if (isset($this->foundTrainingPlanTrainingRepository)) {
            return $this->foundTrainingPlanTrainingRepository;
        }

        if ($id > 0) {
            $plan = $this->createTrainingPlanWithWorkouts();
            $plan->setId($id);
            $this->foundTrainingPlanTrainingRepository = $plan;

            return $plan;
        }

        return null;
    }

    protected function setFoundTrainingRepositoryMock(TrainingPlan $trainingPlan): void
    {
        $this->foundTrainingPlanTrainingRepository = $trainingPlan;
    }
}
