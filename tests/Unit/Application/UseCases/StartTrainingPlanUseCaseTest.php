<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Application\UseCases;

use N0mercy\TrainingPackage\Application\UseCases\StartTrainingUseCase;
use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Entities\Workout;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\TrainingRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;

class StartTrainingPlanUseCaseTest extends TestCase
{
    private TrainingPlanRepositoryInterface $trainingPlanRepository;
    private TrainingRepositoryInterface $trainingRepository;
    private WorkoutActionRepositoryInterface $workoutActionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingPlanRepository = $this->createMock(TrainingPlanRepositoryInterface::class);
        $this->trainingRepository = $this->createMock(TrainingRepositoryInterface::class);
        $this->workoutActionRepository = $this->createMock(WorkoutActionRepositoryInterface::class);
    }

    /**
     * @throws TrainingPlanEmptyException
     */
    public function testHandle(): void
    {
        // arr
        $userId = 1;
        $workout = $this->createMock(Workout::class);
        $workout->method('getCount')
            ->willReturn(10);
        $workout->method('getActionId')
            ->willReturn(1);
        $trainingPlan = $this->createMock(TrainingPlan::class);
        $trainingPlan->method('getId')
            ->willReturn(1);
        $trainingPlan->method('getName')
            ->willReturn('test training plan');
        $trainingPlan->expects($this->once())
            ->method('getCurrentWorkout')
            ->willReturn($workout);
        $this->trainingPlanRepository
            ->expects($this->once())
            ->method('getById')
            ->with($trainingPlan->getId())
            ->willReturn($trainingPlan);
        $this->workoutActionRepository
            ->method('getName')
            ->with($workout->getActionId())
            ->willReturn('test workout');
        $this->trainingRepository
            ->method('save')
            ->with($trainingPlan, $userId)
            ->willReturn($trainingPlan);
        $useCase = new StartTrainingUseCase(
            $this->trainingPlanRepository,
            $this->trainingRepository,
            $this->workoutActionRepository
        );

        // act
        $trainingDTO = $useCase->handle($trainingPlan->getId(), $userId);

        // ass
        $this->assertEquals($trainingPlan->getId(), $trainingDTO->trainingPlanId);
        $this->assertEquals($trainingPlan->getName(), $trainingDTO->trainingPlanName);
        $this->assertEquals(
            $this->workoutActionRepository->getName($workout->getActionId()),
            $trainingDTO->workoutName
        );
        $this->assertEquals($workout->getCount(), $trainingDTO->workoutCount);
    }
}
