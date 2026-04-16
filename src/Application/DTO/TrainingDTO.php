<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\DTO;


readonly class TrainingDTO
{
    public function __construct(
        public int    $trainingPlanId,
        public string $trainingPlanName,
        public ?string $workoutName,
        public ?int    $workoutCount,
    )
    {
    }
}
