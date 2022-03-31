<?php

namespace App\Entity\Traits;

use App\Repository\PinRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;

#[ORM\Entity(repositoryClass: PinRepository::class)]
#[ORM\Table(name: "pins")]
#[ORM\HasLifecycleCallbacks]

trait Timestampable
{
	#[ORM\Column(
    type: "datetime", 
    options: [ "default" => "CURRENT_TIMESTAMP" 
])]
    private $createdAt;

    #[ORM\Column(
    type: "datetime", 
    options: [ "default" => "CURRENT_TIMESTAMP" 
])]
    private $updatedAt;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps()
    {

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTimeImmutable());
        }

        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}