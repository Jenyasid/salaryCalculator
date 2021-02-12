<?php
declare(strict_types=1);

namespace App;

class CountryTaxDeduction implements OperationInterface
{
    public const COUNTRY_TAX_RATE         = 20;
    public const CHILDREN_FOR_BENEFIT     = 3;
    public const CHILDREN_BENEFIT_PERCENT = 2;

    public function calculate(Employee $employee, float $salary): float
    {
        $percent = $employee->getKids() >= self::CHILDREN_FOR_BENEFIT ? self::COUNTRY_TAX_RATE - self::CHILDREN_BENEFIT_PERCENT : self::COUNTRY_TAX_RATE;

        return $salary * (100 - $percent) / 100;
    }
}
