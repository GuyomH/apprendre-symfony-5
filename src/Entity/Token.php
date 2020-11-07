<?php

namespace App\Entity;

use App\Repository\TokenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TokenRepository::class)
 */
class Token
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * Token constructor.
     */
    public function __construct(User $user)
    {
        $this->createdAt = new \DateTime(); // Date de création du token
        $this->value = md5(uniqid()); // Valeur du token
        $this->user = $user;
        $user->setEnable(false); // Propriété enable à false par défaut
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isValid()
    {
        // http://www.lephpfacile.com/manuel-php/dateinterval.construct.php (explication PT)
        // https://www.php.net/manual/fr/dateinterval.format.php
        // On crée un intervalle de 1H
        $interval = new \DateInterval('PT1H');
        // On ajoute l'intervalle à la date de création du token
        // et on retourne true si celle-ci est supérieure ou égale à la date et heure actuelle
        return $this->createdAt->add($interval) >= new \DateTime();
    }
}
