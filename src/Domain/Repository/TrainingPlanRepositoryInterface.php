<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Repository;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;

interface TrainingPlanRepositoryInterface
{
    public function getById(int $id, int $userId): ?TrainingPlan;
    public function save(TrainingPlan $trainingPlan, int $userId): TrainingPlan;
}
