<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\UseCases;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;

readonly class FindTrainingPlanByIdUseCase
{
    public function __construct(
        private TrainingPlanRepositoryInterface $trainingPlanRepository
    )
    {
    }

    public function handle(int $id, int $userId): TrainingPlan
    {
        return $this->trainingPlanRepository->getById($id, $userId);
    }
}
