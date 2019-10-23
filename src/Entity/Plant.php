<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlantRepository")
 */
class Plant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prefecture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $locality;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_plants;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_likes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image_1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_2;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at1;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="plants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function __construct(){
        $this->created_at1 = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->nb_likes = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPrefecture(): ?string
    {
        return $this->prefecture;
    }

    public function setPrefecture(?string $prefecture): self
    {
        $this->prefecture = $prefecture;

        return $this;
    }

    public function getLocality(): ?string
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getNbPlants(): ?int
    {
        return $this->nb_plants;
    }

    public function setNbPlants(int $nb_plants): self
    {
        $this->nb_plants = $nb_plants;

        return $this;
    }

    public function getNbLikes(): ?int
    {
        return $this->nb_likes;
    }

    public function setNbLikes(int $nb_likes): self
    {
        $this->nb_likes = $nb_likes;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image_1;
    }

    public function setImage1(string $image_1): self
    {
        $this->image_1 = $image_1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image_2;
    }

    public function setImage2(?string $image_2): self
    {
        $this->image_2 = $image_2;

        return $this;
    }

    public function getCreatedAt1(): ?\DateTimeInterface
    {
        return $this->created_at1;
    }

    public function setCreatedAt1(\DateTimeInterface $created_at1): self
    {
        $this->created_at1 = $created_at1;
        $this->updated_at = $created_at1;

        return $this;
    }

    public function getCreatedAt2(): ?\DateTimeInterface
    {
        return $this->created_at2;
    }

    public function setCreatedAt2(?\DateTimeInterface $created_at2): self
    {
        $this->created_at2 = $created_at2;
        $this->updated_at = $created_at2;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
