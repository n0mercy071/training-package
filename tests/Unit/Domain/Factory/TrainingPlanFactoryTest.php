<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Domain\Factory;

use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactory;
use N0mercy\TrainingPackage\Domain\Factory\TrainingPlanFactoryInterface;
use Faker\Generator;
use N0mercy\TrainingPackage\Tests\TestCase;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;

class TrainingPlanFactoryTest extends TestCase
{
    private TrainingPlanFactory|TrainingPlanFactoryInterface $trainingPlanFactory;
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingPlanFactory = new TrainingPlanFactory();
        $this->faker = FakerTool::faker();
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
