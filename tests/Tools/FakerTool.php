<?php

declare(strict_types=1);


namespace N0mercy\TrainingPackage\Tests\Tools;

use Faker\Factory;
use Faker\Generator;

class FakerTool
{
    public static function faker(): Generator
    {
        return Factory::create('ru_RU');
    }
}
