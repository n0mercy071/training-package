<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;

class TrainingPlanFactoryTest extends TestCase
{
    private TrainingPlanFactory|TrainingPlanFactoryInterface $trainingPlanFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingPlanFactory = new TrainingPlanFactory();
    }

    public function testCreate(): void
    {
        // arr
        $wordCount = $this->faker->numberBetween(1, 6);
        $name = $this->faker->words($wordCount, true);

        // act
        $trainingPlan = $this->trainingPlanFactory->create($name);

        // ass
        $this->assertInstanceOf(TrainingPlan::class, $trainingPlan);
        $this->assertEquals($name, $trainingPlan->getName());
    }
}
