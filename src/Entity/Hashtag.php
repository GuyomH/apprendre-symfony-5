<?php

namespace App\Entity;

use App\Repository\HashtagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HashtagRepository::class)
 */
class Hashtag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le hashtag doit être renseigné !")
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Le hashtag doit faire au minimum {{ limit }} caractères !",
     *      maxMessage = "Le hashtag doit faire au maximum {{ limit }} caractères !"
     * )
     */
    private $terme;

    /**
     * @ORM\ManyToOne(targetEntity=Film::class, inversedBy="hashtags")
     */
    private $film;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerme(): ?string
    {
        return $this->terme;
    }

    public function setTerme(string $terme): self
    {
        $this->terme = $terme;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        $this->film = $film;

        return $this;
    }
}
