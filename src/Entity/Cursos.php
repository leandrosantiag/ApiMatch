<?php

namespace App\Entity;

use App\Repository\CursosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursosRepository::class)]
class Cursos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titulo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $descricao;

    #[ORM\Column(type: 'date', nullable: true)]
    private $data_inicio;

    #[ORM\Column(type: 'date', nullable: true)]
    private $data_fim;

    #[ORM\Column(type: 'smallint')]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getDataInicio(): ?\DateTimeInterface
    {
        return $this->data_inicio;
    }

    public function setDataInicio(?\DateTimeInterface $data_inicio): self
    {
        $this->data_inicio = $data_inicio;

        return $this;
    }

    public function getDataFim(): ?\DateTimeInterface
    {
        return $this->data_fim;
    }

    public function setDataFim(?\DateTimeInterface $data_fim): self
    {
        $this->data_fim = $data_fim;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
