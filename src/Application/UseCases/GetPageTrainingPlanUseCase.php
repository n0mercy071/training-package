<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\GetPageTrainingPlanDTO;
use N0mercy\TrainingPackage\Application\Exception\InvalidParamsGetPageTrainingPlanUseCaseException;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;

class GetPageTrainingPlanUseCase
{
    public function __construct(
        private TrainingPlanRepositoryInterface $trainingPlanRepository,
    )
    {
    }

    /**
     * @throws InvalidParamsGetPageTrainingPlanUseCaseException
     */
    public function handle(
        int $userId,
        int $page,
        int $pageSize
    ): GetPageTrainingPlanDTO
    {
        if (
            $userId <= 0 ||
            $page <= 0 ||
            $pageSize <= 0 ||
            $pageSize > 100
        ) {
            throw new InvalidParamsGetPageTrainingPlanUseCaseException();
        }

        return $this->trainingPlanRepository->getPage($userId, $page, $pageSize);
    }
}
