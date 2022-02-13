<?php

namespace App\Entity;

use App\Repository\ModuleHyperlinkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModuleHyperlinkRepository::class)]
class ModuleHyperlink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    private $url;

    #[ORM\ManyToOne(targetEntity: Module::class, inversedBy: "moduleHyperlinks")]
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

    public function getUrl()
    {
        return $this->url;
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

    public function setUrl($url): self
    {
        $this->url = $url;

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
