<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Unit\Application\UseCases;

use N0mercy\TrainingPackage\Application\Exception\InvalidParamsGetPageTrainingPlanUseCaseException;
use N0mercy\TrainingPackage\Application\UseCases\GetPageTrainingPlanUseCase;
use N0mercy\TrainingPackage\Domain\Entities\TrainingPlan;
use N0mercy\TrainingPackage\Domain\Repository\TrainingPlanRepositoryInterface;
use N0mercy\TrainingPackage\Tests\TestCase;
use N0mercy\TrainingPackage\Tests\Tools\FakerTool;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;

class GetPageTrainingPlanUseCaseTest extends TestCase
{
    private TrainingPlanRepositoryInterface&MockObject $trainingPlanRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trainingPlanRepository = $this->createMockTrainingPlanRepository();
    }

    /**
     * @throws InvalidParamsGetPageTrainingPlanUseCaseException
     */
    public function testHandleCorrect(): void
    {
        // arr
        $userId = 1;
        $page = 1;
        $pageSize = 10;
        $useCase = new GetPageTrainingPlanUseCase(
            $this->trainingPlanRepository,
        );

        // act
        $response = $useCase->handle($userId, $page, $pageSize);

        // ass
        $this->assertEquals($page, $response->currentPage);
        $this->assertEquals($pageSize, $response->pageSize);
        $this->assertInstanceOf(TrainingPlan::class, current($response->items));
    }

    #[DataProvider('invalidParamsDataProvider')]
    public function testHandleInvalidParams(int $userId, int $page, $pageSize): void
    {
        $useCase = new GetPageTrainingPlanUseCase(
            $this->trainingPlanRepository,
        );

        // act
        $this->expectException(InvalidParamsGetPageTrainingPlanUseCaseException::class);
        $useCase->handle($userId, $page, $pageSize);

        // ass
    }

    public static function invalidParamsDataProvider(): array
    {
        $faker = FakerTool::faker();

        return [
            [
                'userId' => $faker->numberBetween(-1000, 0),
                'page' => $faker->numberBetween(1, 1000),
                'pageSize' => $faker->numberBetween(1, 100),
            ],
            [
                'userId' => $faker->numberBetween(1, 1000),
                'page' => $faker->numberBetween(-1000, 0),
                'pageSize' => $faker->numberBetween(1, 100),
            ],
            [
                'userId' => $faker->numberBetween(1, 1000),
                'page' => $faker->numberBetween(1, 1000),
                'pageSize' => $faker->numberBetween(-1000, 0),
            ],
            [
                'userId' => $faker->numberBetween(1, 1000),
                'page' => $faker->numberBetween(1, 1000),
                'pageSize' => $faker->numberBetween(100, 1000),
            ],
        ];
    }
}
