<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
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
    private string $description;

    #[ORM\Column]
    private int $passengerCount;

    #[ORM\Column]
    private string $pricePerDay;

    /** @var string[] */
    #[ORM\Column(type: 'json')]
    private array $imageFilenames = [];

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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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

    /**
     * @return string[]
     */
    public function getImageFilenames(): array
    {
        return $this->imageFilenames;
    }

    public function addImage(string $imageFilename): void
    {
        $this->setImageFilenames([...$this->getImageFilenames(), $imageFilename]);
    }

    public function removeImage(string $imageFilename): void
    {
        $this->setImageFilenames(
            array_filter(
                $this->getImageFilenames(),
                fn(string $filename) => $filename !== $imageFilename
            )
        );
    }

    public function getFirstImage(): string
    {
        //TODO handle null pointer
        return array_values($this->getImageFilenames())[0];
    }

    /**
     * @param string[] $imageFilenames
     */
    private function setImageFilenames(array $imageFilenames): void
    {
        $this->imageFilenames = $imageFilenames;
    }

    public function __toString() {
        return $this->name;
    }
}
