<?php

declare(strict_types=1);

namespace N0mercy\TrainingPackage\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;

interface TrainingPlanFactoryInterface
{
    public function create(string $name): TrainingPlan;
}
