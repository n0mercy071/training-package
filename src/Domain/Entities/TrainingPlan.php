<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Domain\Entities;

use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanEmptyException;
use N0mercy\TrainingPackage\Domain\Exception\TrainingPlanIdNotPositive;

class TrainingPlan
{
    private ?int $id = null;
    /** @var Workout[] $workouts */
    private array $workouts = [];

    public function __construct(
        private readonly string $name,
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @throws TrainingPlanIdNotPositive
     */
    public function setId(int $id): TrainingPlan
    {
        if ($id <= 0) {
            throw new TrainingPlanIdNotPositive('ID плана тренировки не положителен');
        }

        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param Workout $workout
     * @return $this
     */
    public function addWorkout(Workout $workout): TrainingPlan
    {
        $this->workouts[] = $workout;

        return $this;
    }

    /**
     * @param Workout[] $workouts
     * @return $this
     */
    public function addWorkouts(array $workouts): TrainingPlan
    {
        foreach ($workouts as $workout) {
            $this->addWorkout($workout);
        }

        return $this;
    }

    /**
     * @return Workout[]
     */
    public function getWorkouts(): array
    {
        return $this->workouts;
    }

    /**
     * @return null|Workout null - если все упражнения выполнены
     * @throws TrainingPlanEmptyException если план тренировки пустой
     */
    public function getCurrentWorkout(): ?Workout
    {
        if (empty($this->workouts)) {
            throw new TrainingPlanEmptyException();
        }

        foreach ($this->workouts as $workout) {
            if (!is_null($workout->getCount())) {
                continue;
            }

            return $workout;
        }

        return null;
    }

    public function getWorkoutCount(): int
    {
        return count($this->workouts);
    }

    public function getWorkoutCompletedCount(): int
    {
        return count(
            array_filter(
                $this->workouts,
                fn (Workout $workout) => !is_null($workout->getCount())
            )
        );
    }
}
