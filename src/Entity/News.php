<?php

namespace App\Entity;

use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsRepository::class)]
class News
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $News;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNews(): ?string
    {
        return $this->News;
    }

    public function setNews(string $News): self
    {
        $this->News = $News;

        return $this;
    }
}
