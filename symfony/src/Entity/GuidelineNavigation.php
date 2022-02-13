<?php

namespace App\Entity;

use App\Repository\GuidelineNavigationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuidelineNavigationRepository::class)]
class GuidelineNavigation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\ManyToOne(targetEntity: Guideline::class, inversedBy: "guidelineNavigations")]
    private $guideline;

    #[ORM\ManyToOne(targetEntity: Module::class, inversedBy: "guidelineNavigations")]
    private $module;

    #[ORM\Column(type: 'string', length: 255)]
    private $externalId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getGuideline(): ?Guideline
    {
        return $this->guideline;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setGuideline($guideline): self
    {
        $this->guideline = $guideline;

        return $this;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;

        return $this;
    }

    public function setExternalId($externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }
}
