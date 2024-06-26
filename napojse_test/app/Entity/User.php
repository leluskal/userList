<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user", uniqueConstraints={@UniqueConstraint(name="email_idx", columns={"email"})})
 */
class User extends AbstractEntity
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $fullName;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }
}