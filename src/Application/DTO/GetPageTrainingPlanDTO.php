<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\DTO;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;

readonly class GetPageTrainingPlanDTO
{
    /**
     * @param TrainingPlan[] $items
     */
    public function __construct(
        public int   $currentPage,
        public int   $pageSize,
        public int   $totalPages,
        public int   $totalItems,
        public array $items,
    )
    {
    }
}
