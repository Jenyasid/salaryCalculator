<?php
declare(strict_types=1);

namespace App;

class Calculator
{
    /** @var Employee */
    private $employee;

    /** @var OperationInterface */
    private $operation;

    /** @var float */
    private $salary;

    public function setEmployee(Employee $employee): void
    {
        if ($employee->getSalary() === null) {
            throw new \RuntimeException('Salary is not defined');
        }

        if ($employee->getAge() === null) {
            throw new \RuntimeException('Age is not defined');
        }

        $this->employee = $employee;
        $this->setSalary($this->employee->getSalary());
    }

    public function setOperation(OperationInterface $operation): void
    {
        $this->operation = $operation;
    }

    public function calculateSalary(): void
    {
        if (!$this->employee) {
            throw new \RuntimeException('Employee is not set');
        }

        if (!$this->operation) {
            throw new \RuntimeException('Operation is not set');
        }

        $this->salary = $this->operation->calculate($this->employee, $this->salary);
    }

    public function getSalary(): float
    {
        return $this->salary;
    }

    private function setSalary(float $salary): void
    {
        $this->salary = $salary;
    }
}
