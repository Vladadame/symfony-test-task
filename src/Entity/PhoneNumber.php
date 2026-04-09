<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\PhoneNumberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhoneNumberRepository::class)]
class PhoneNumber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private string $phoneNumber;

    #[ORM\ManyToOne(inversedBy: 'phoneNumbers')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?UserRecord $userRecord = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getUserRecord(): ?UserRecord
    {
        return $this->userRecord;
    }

    public function setUserRecord(?UserRecord $userRecord): self
    {
        $this->userRecord = $userRecord;

        return $this;
    }
}