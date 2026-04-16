<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Tests\Unit\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\CreateTrainingPlanDTO;
use N0mercy\TrainingPackage\Application\UseCases\CreateTrainingPlanUseCase;
use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanIdNotPositive;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;

class CreateTrainingPlanUseCaseTest extends TestCase
{
    private TrainingPlanRepositoryInterface $trainingPlanRepository;
    private TrainingPlanFactoryInterface $trainingPlanFactory;
    /** @var Workout[] $workouts */
    private array $workouts;

    /**
     * @throws TrainingPlanIdNotPositive
     */
    protected function setUp(): void
    {
        parent::setUp();
        $workoutActionRepository = $this->createMock(WorkoutActionRepositoryInterface::class);
        $workoutActionRepository->method('exists')->willReturn(true);
        $this->workouts = [
            $this->createWorkout(),
        ];
        $this->trainingPlanFactory = new TrainingPlanFactory();
        $this->trainingPlanRepository = $this->createMock(TrainingPlanRepositoryInterface::class);
        $trainingPlan = $this->trainingPlanFactory->create('test');
        $trainingPlan->setId(1);
        $trainingPlan->addWorkouts($this->workouts);
        $this->trainingPlanRepository->method('save')->willReturn($trainingPlan);
    }

    public function testHandle(): void
    {
        // arr
        $dto = new CreateTrainingPlanDTO(
            'test',
            $this->workouts,
        1
        );
        $useCase = new CreateTrainingPlanUseCase(
            $this->trainingPlanRepository,
            $this->trainingPlanFactory,
        );

        // act
        $trainingPlan = $useCase->handle($dto);

        // ass
        $this->assertIsInt($trainingPlan->getId());
        $this->assertEquals($trainingPlan->getName(), $dto->name);
        $this->assertEquals($trainingPlan->getWorkouts(), $dto->workouts);
    }
}
