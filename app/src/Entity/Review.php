<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;

#[ORM\Entity]
class Review
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Yacht::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private Yacht $yacht;

    #[ORM\ManyToOne(targetEntity: User::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column]
    private string $text;

    #[ORM\Column]
    private int $rating;

    #[ORM\Column(type: 'datetimetz_immutable')]
    private DateTimeImmutable $createDate;

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
     * @return Yacht
     */
    public function getYacht(): Yacht
    {
        return $this->yacht;
    }

    /**
     * @param Yacht $yacht
     */
    public function setYacht(Yacht $yacht): void
    {
        $this->yacht = $yacht;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreateDate(): DateTimeImmutable
    {
        return $this->createDate;
    }

    /**
     * @param DateTimeImmutable $createDate
     */
    public function setCreateDate(DateTimeImmutable $createDate): void
    {
        $this->createDate = $createDate;
    }

}