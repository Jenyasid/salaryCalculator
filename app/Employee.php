<?php
declare(strict_types=1);

namespace App;

/**
 * Class Employee
 */
class Employee
{
    /** @var string */
    private $name;
    /** @var int */
    private $age;
    /** @var int */
    private $kids = 0;
    /** @var bool */
    private $useCompanyCar = false;
    /** @var float */
    private $salary;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getKids(): int
    {
        return $this->kids;
    }

    public function setKids(int $kids): self
    {
        $this->kids = $kids;
        return $this;
    }

    public function isUseCompanyCar(): bool
    {
        return $this->useCompanyCar;
    }

    public function setUseCompanyCar(bool $useCompanyCar): self
    {
        $this->useCompanyCar = $useCompanyCar;
        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;
        return $this;
    }
}
