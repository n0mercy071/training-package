<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Application\UseCases;

use N0mercy\TrainingPackage\Application\UseCases\FindTrainingPlanByIdUseCase;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanIdNotPositive;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Tests\Fixtures\Domain\TrainingPlanFixture;
use N0mercy\TrainingPackage\Tests\TestCase;

class FindTrainingPlanByIdUseCaseTest extends TestCase
{
    private TrainingPlanRepositoryInterface $trainingPlanRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingPlanRepository = $this->createMock(TrainingPlanRepositoryInterface::class);
    }

    /**
     * @throws TrainingPlanIdNotPositive
     */
    public function testHandle(): void
    {
        // arr
        $trainingPlanId = 1;
        $userId = 1;
        $trainingPlan = TrainingPlanFixture::createTrainingPlanWithWorkouts();
        $trainingPlan->setId($trainingPlanId);
        $this->trainingPlanRepository
            ->expects($this->once())
            ->method('getById')
            ->with($trainingPlanId, $userId)
            ->willReturn($trainingPlan);
        $useCase = new FindTrainingPlanByIdUseCase(
            $this->trainingPlanRepository
        );

        // act
        $trainingPlan = $useCase->handle($trainingPlanId, $userId);

        // ass
        $this->assertEquals($trainingPlanId, $trainingPlan->getId());
    }
}
