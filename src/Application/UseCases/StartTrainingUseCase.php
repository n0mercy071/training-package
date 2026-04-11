<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\TrainingDTO;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\TrainingRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;

readonly class StartTrainingUseCase
{
    public function __construct(
        private TrainingPlanRepositoryInterface $trainingPlanRepository,
        private TrainingRepositoryInterface $trainingRepository,
        private WorkoutActionRepositoryInterface $workoutActionRepository,
    )
    {
    }

    /**
     * @throws TrainingPlanEmptyException
     */
    public function handle(int $id, int $userId): TrainingDTO
    {
        $trainingPlan = $this->trainingPlanRepository->getById($id, $userId);

        $workout = $trainingPlan->getCurrentWorkout();
        $this->trainingRepository->save($trainingPlan, $userId);

        return new TrainingDTO(
            $trainingPlan->getId(),
            $trainingPlan->getName(),
            $this->workoutActionRepository->getName($workout->getActionId()),
            $workout->getCount()
        );
    }
}
