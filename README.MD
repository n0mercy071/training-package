# Training Package
Пакет для composer (PHP 8.2)

`composer analyse` - скрипт быстрого запуска Deptrac + PHPStan + PHPUnit

## Use Cases
Шаблонный метод **handle**
1. CreateTrainingPlanUseCase - создать план тренировки
2. FindTrainingPlanUseCase - найти план тренировки
3. StartTrainingUseCase - начать тренировку
4. ProcessTrainingUseCase - "процесс" тренировки. Вернет null вместо Workout, когда упражнения закончатся
