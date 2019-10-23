<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigRepository")
 */
class Config
{

    const START_DATE_1 = 'start_date1';
    const END_DATE_1   = 'end_date1';
    const START_DATE_2 = 'start_date2';
    const END_DATE_2   = 'end_date2';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ckey;

    /**
     * @ORM\Column(type="text")
     */
    private $cvalue;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCkey(): ?string
    {
        return $this->ckey;
    }

    public function setCkey(string $ckey): self
    {
        $this->ckey = $ckey;

        return $this;
    }

    public function getCvalue(): ?string
    {
        return $this->cvalue;
    }

    public function setCvalue(string $cvalue): self
    {
        $this->cvalue = $cvalue;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
