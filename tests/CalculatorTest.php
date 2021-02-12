<?php
declare(strict_types=1);

use App\AgeBenefit;
use App\Calculator;
use App\CarUseDeduction;
use App\CountryTaxDeduction;
use App\Employee;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /** @var Calculator */
    private $calculator;

    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /**
     * Tests country tax deduction
     */
    public function testCountryTaxDeduction(): void
    {
        $employees = $this->getEmployeesFixtures();

        $this->calculator->setOperation(new CountryTaxDeduction());

        foreach ($employees as $employee) {
            $employeeEntity = (new Employee())
                ->setName($employee['name'])
                ->setAge($employee['age'])
                ->setKids($employee['kids'])
                ->setSalary($employee['salary'])
                ->setUseCompanyCar($employee['useCompanyCar']);

            $this->calculator->setEmployee($employeeEntity);
            $this->calculator->calculateSalary();

            $percent = $employee['kids'] >= CountryTaxDeduction::CHILDREN_FOR_BENEFIT
                ? CountryTaxDeduction::COUNTRY_TAX_RATE - CountryTaxDeduction::CHILDREN_BENEFIT_PERCENT
                : CountryTaxDeduction::COUNTRY_TAX_RATE;

            self::assertEquals($employee['salary'] * (100 - $percent) / 100, $this->calculator->getSalary());
        }
    }

    /**
     * Tests age benefit
     */
    public function testAgeBenefit(): void
    {
        $employees = $this->getEmployeesFixtures();

        $this->calculator->setOperation(new AgeBenefit());

        foreach ($employees as $employee) {
            $employeeEntity = (new Employee())
                ->setName($employee['name'])
                ->setAge($employee['age'])
                ->setKids($employee['kids'])
                ->setSalary($employee['salary'])
                ->setUseCompanyCar($employee['useCompanyCar']);

            $this->calculator->setEmployee($employeeEntity);
            $this->calculator->calculateSalary();

            self::assertEquals($employee['age'] > AgeBenefit::BENEFIT_BY_AGE
                ? $employee['salary'] * (100 + AgeBenefit::BENEFIT_BY_AGE_PERCENT) / 100
                : $employee['salary'],
                $this->calculator->getSalary()
            );
        }
    }

    /**
     * Tests company car use deduction
     */
    public function testCarUseDeduction(): void
    {
        $employees = $this->getEmployeesFixtures();

        $this->calculator->setOperation(new CarUseDeduction());

        foreach ($employees as $employee) {
            $employeeEntity = (new Employee())
                ->setName($employee['name'])
                ->setAge($employee['age'])
                ->setKids($employee['kids'])
                ->setSalary($employee['salary'])
                ->setUseCompanyCar($employee['useCompanyCar']);

            $this->calculator->setEmployee($employeeEntity);
            $this->calculator->calculateSalary();

            self::assertEquals($employee['useCompanyCar'] ? $employee['salary'] - CarUseDeduction::COMPANY_USE_CAR_DEDUCTION : $employee['salary'], $this->calculator->getSalary());
        }
    }

    /**
     * Tests total salary calculation
     */
    public function testSalaryCalculation()
    {
        $employees = $this->getEmployeesFixtures();

        foreach ($employees as $employee) {
            $employeeEntity = (new Employee())
                ->setName($employee['name'])
                ->setAge($employee['age'])
                ->setKids($employee['kids'])
                ->setSalary($employee['salary'])
                ->setUseCompanyCar($employee['useCompanyCar']);

            $this->calculator->setEmployee($employeeEntity);
            $this->calculator->setOperation(new AgeBenefit());
            $this->calculator->calculateSalary();
            $this->calculator->setOperation(new CarUseDeduction());
            $this->calculator->calculateSalary();
            $this->calculator->setOperation(new CountryTaxDeduction());
            $this->calculator->calculateSalary();

            self::assertEquals($employee['calculatedSalary'], $this->calculator->getSalary());
        }
    }

    /**
     * Returns test fixtures
     */
    private function getEmployeesFixtures(): array
    {
        return [
            [
                'name'             => 'Alice',
                'age'              => 26,
                'kids'             => 2,
                'salary'           => 6000,
                'useCompanyCar'    => false,
                'calculatedSalary' => 4800,
            ],
            [
                'name'             => 'Bob',
                'age'              => 52,
                'kids'             => 0,
                'salary'           => 4000,
                'useCompanyCar'    => true,
                'calculatedSalary' => 3024,
            ],
            [
                'name'             => 'Charlie',
                'age'              => 36,
                'kids'             => 3,
                'salary'           => 5000,
                'useCompanyCar'    => true,
                'calculatedSalary' => 3690,
            ],
        ];
    }
}
