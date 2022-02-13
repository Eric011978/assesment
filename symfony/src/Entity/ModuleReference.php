<?php

namespace App\Entity;

use App\Repository\ModuleReferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleReferenceRepository::class)]
class ModuleReference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $content;

    #[ORM\ManyToOne(targetEntity: Module::class, inversedBy: "moduleReferences")]
    private $module;

    #[ORM\Column(type: 'string', length: 255)]
    private $externalId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function getExternalId()
    {
        return $this->externalId;
    }

    public function setContent($content): self
    {
        $this->content = $content;

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
