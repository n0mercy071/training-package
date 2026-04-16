<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Repository;


use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;

interface TrainingRepositoryInterface
{
    public function save(TrainingPlan $trainingPlan, int $userId): TrainingPlan;

    public function find(int $trainingPlanId, int $userId): ?TrainingPlan;
}
