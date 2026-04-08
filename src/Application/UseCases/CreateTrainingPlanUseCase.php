<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\CreateTrainingPlanDTO;
use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;

class CreateTrainingPlanUseCase
{
    public function __construct(
        private TrainingPlanRepositoryInterface $trainingPlanRepository,
        private TrainingPlanFactoryInterface $trainingPlanFactory
    )
    {
    }

    public function handle(CreateTrainingPlanDTO $dto): TrainingPlan
    {
        $trainingPlan = $this->trainingPlanFactory->create($dto->name);
        $trainingPlan->addWorkouts($dto->workouts);

        return $this->trainingPlanRepository->save($trainingPlan, $dto->userId);
    }
}
