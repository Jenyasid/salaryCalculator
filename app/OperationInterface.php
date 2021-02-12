<?php
declare(strict_types=1);

namespace App;

interface OperationInterface
{
    public function calculate(Employee $employee, float $salary): float;
}
