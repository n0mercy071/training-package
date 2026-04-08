<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\DTO;

use N0mercy\TrainingPackage\Domain\Entities\Workout;

readonly class CreateTrainingPlanDTO
{
    /**
     * @param Workout[] $workouts
     */
    public function __construct(
        public string $name,
        public array  $workouts,
        public int $userId,
    )
    {
    }
}
