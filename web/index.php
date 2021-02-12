<?php
declare(strict_types=1);

use App\AgeBenefit;
use App\Calculator;
use App\CarUseDeduction;
use App\CountryTaxDeduction;
use App\Employee;

require_once __DIR__.'/../vendor/autoload.php';

$employees = [
    [
        'name'          => 'Alice',
        'age'           => 26,
        'kids'          => 2,
        'salary'        => 6000,
        'useCompanyCar' => false,
    ],
    [
        'name'          => 'Bob',
        'age'           => 52,
        'kids'          => 0,
        'salary'        => 4000,
        'useCompanyCar' => true,
    ],
    [
        'name'          => 'Charlie',
        'age'           => 36,
        'kids'          => 3,
        'salary'        => 5000,
        'useCompanyCar' => true,
    ],
];

$calculator = new Calculator();

foreach ($employees as $employee) {
    $employeeEntity = (new Employee())
        ->setName($employee['name'])
        ->setAge($employee['age'])
        ->setKids($employee['kids'])
        ->setSalary($employee['salary'])
        ->setUseCompanyCar($employee['useCompanyCar']);

    try {
        $calculator->setEmployee($employeeEntity);
    } catch (RuntimeException $e) {
        echo \sprintf('%s: %s', $employee['name'], $e->getMessage()) . PHP_EOL;
        continue;
    }

    $calculator->setOperation(new AgeBenefit());

    try {
        $calculator->calculateSalary();
    } catch (RuntimeException $e) {
        echo \sprintf('%s: %s', $employee['name'], $e->getMessage()) . PHP_EOL;
        continue;
    }

    $calculator->setOperation(new CarUseDeduction());

    try {
        $calculator->calculateSalary();
    } catch (RuntimeException $e) {
        echo \sprintf('%s: %s', $employee['name'], $e->getMessage()) . PHP_EOL;
        continue;
    }

    $calculator->setOperation(new CountryTaxDeduction());

    try {
        $calculator->calculateSalary();
    } catch (RuntimeException $e) {
        echo \sprintf('%s: %s', $employee['name'], $e->getMessage()) . PHP_EOL;
        continue;
    }

    echo \sprintf('Calculated salary for %s is %.2F', $employee['name'], $calculator->getSalary()) . PHP_EOL;
}
