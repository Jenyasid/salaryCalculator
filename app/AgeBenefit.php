<?php
declare(strict_types=1);

namespace App;

class AgeBenefit implements OperationInterface
{
    public const BENEFIT_BY_AGE         = 50;
    public const BENEFIT_BY_AGE_PERCENT = 7;

    public function calculate(Employee $employee, float $salary): float
    {
        return $employee->getAge() > self::BENEFIT_BY_AGE ? $salary * (100 + self::BENEFIT_BY_AGE_PERCENT) / 100 : $salary;
    }
}
