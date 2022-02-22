<?php

namespace App\Entity;

use App\Repository\MatriculasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatriculasRepository::class)]
class Matriculas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $curso_id;

    #[ORM\Column(type: 'integer')]
    private $aluno_id;

    #[ORM\Column(type: 'integer')]
    private $user_id;

    #[ORM\Column(type: 'date')]
    private $data_matricula;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCursoId(): ?int
    {
        return $this->curso_id;
    }

    public function setCursoId(int $curso_id): self
    {
        $this->curso_id = $curso_id;

        return $this;
    }

    public function getAlunoId(): ?int
    {
        return $this->aluno_id;
    }

    public function setAlunoId(int $aluno_id): self
    {
        $this->aluno_id = $aluno_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDataMatricula(): ?\DateTimeInterface
    {
        return $this->data_matricula;
    }

    public function setDataMatricula(\DateTimeInterface $data_matricula): self
    {
        $this->data_matricula = $data_matricula;

        return $this;
    }
}
