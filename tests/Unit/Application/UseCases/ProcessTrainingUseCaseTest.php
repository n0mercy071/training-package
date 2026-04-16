<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\TrainingDTO;
use N0mercy\TrainingPackage\Application\Exception\TrainingNotFoundException;
use N0mercy\TrainingPackage\Application\UseCases\ProcessTrainingUseCase;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Repository\TrainingRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class ProcessTrainingUseCaseTest extends TestCase
{
    private TrainingRepositoryInterface&MockObject $trainingRepository;
    private WorkoutActionRepositoryInterface&MockObject $workoutActionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingRepository = $this->createMockTrainingRepository();
        $this->workoutActionRepository = $this->createMockWorkoutActionRepository();
    }

    /**
     * @throws TrainingNotFoundException
     * @throws TrainingPlanEmptyException
     */
    public function testHandle(): void
    {
        // arr
        $trainingPlanId = 1;
        $count = 10;
        $userId = 1;
        $this->trainingRepository
            ->expects($this->once())
            ->method('find')
            ->with($trainingPlanId, $userId);
        $useCase = new ProcessTrainingUseCase(
            $this->trainingRepository,
            $this->workoutActionRepository,
        );

        // act
        $dto = $useCase->handle($trainingPlanId, $userId, $count);

        // ass
        $this->assertInstanceOf(TrainingDTO::class, $dto);
    }
}
