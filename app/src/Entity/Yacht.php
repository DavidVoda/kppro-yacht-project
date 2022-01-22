<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Yacht
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\Column]
    private string $name;

    #[ORM\Column]
    private string $model;

    #[ORM\Column]
    private int $passengerCount;

    #[ORM\Column]
    private string $pricePerDay;

    public function __construct()
    {
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = Uuid::fromString($id);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getPassengerCount(): int
    {
        return $this->passengerCount;
    }

    /**
     * @param int $passengerCount
     */
    public function setPassengerCount(int $passengerCount): void
    {
        $this->passengerCount = $passengerCount;
    }

    /**
     * @return string
     */
    public function getPricePerDay(): string
    {
        return $this->pricePerDay;
    }

    /**
     * @param string $pricePerDay
     */
    public function setPricePerDay(string $pricePerDay): void
    {
        $this->pricePerDay = $pricePerDay;
    }
}
