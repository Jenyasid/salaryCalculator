<?php
declare(strict_types=1);

namespace App;


class CarUseDeduction implements OperationInterface
{
    public const COMPANY_USE_CAR_DEDUCTION = 500;

    public function calculate(Employee $employee, float $salary): float
    {
        return $employee->isUseCompanyCar() ? $salary - self::COMPANY_USE_CAR_DEDUCTION : $salary;
    }
}
