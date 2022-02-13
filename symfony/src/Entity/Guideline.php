<?php

namespace App\Entity;

use App\Repository\GuidelineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuidelineRepository::class)]
class Guideline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $externalId;

    #[ORM\OneToMany(targetEntity: GuidelineNavigation::class, mappedBy: "guideline")]
    private $guidelineNavigations;

    public function __construct()
    {
        $this->guidelineNavigations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    public function getGuidelineNavigations(): Collection
    {
        return $this->guidelineNavigations;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setExternalId($externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }
}
