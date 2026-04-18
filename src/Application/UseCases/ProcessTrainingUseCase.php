<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Application\UseCases;

use N0mercy\TrainingPackage\Application\DTO\TrainingDTO;
use N0mercy\TrainingPackage\Application\Exception\TrainingNotFoundException;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Repository\TrainingRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutActionRepositoryInterface;
use N0mercy\TrainingPackage\Domain\Repository\WorkoutLogRepositoryInterface;

readonly class ProcessTrainingUseCase
{

    public function __construct(
        private TrainingRepositoryInterface      $trainingRepository,
        private WorkoutActionRepositoryInterface $workoutActionRepository,
        private WorkoutLogRepositoryInterface    $workoutLogRepository,
    )
    {
    }

    /**
     * @throws TrainingNotFoundException
     * @throws TrainingPlanEmptyException
     */
    public function handle(int $trainingPlanId, int $userId, int $count): TrainingDTO
    {
        $trainingPlan = $this->trainingRepository->find($trainingPlanId, $userId);
        if (is_null($trainingPlan)) {
            throw new TrainingNotFoundException(
                'Training not found for user ' . $userId,
            );
        }

        $workout = $trainingPlan->getCurrentWorkout();
        $workout->completed($count);
        $this->workoutLogRepository->save($workout);
        $trainingPlan = $this->trainingRepository->save($trainingPlan, $userId);

        $workout = $trainingPlan->getCurrentWorkout();
        return new TrainingDTO(
            $trainingPlan->getId(),
            $trainingPlan->getName(),
            is_null($workout) ?
                null :
                $this->workoutActionRepository->getName($workout->getActionId()),
            is_null($workout) ? null : $workout->getCount()
        );
    }
}
