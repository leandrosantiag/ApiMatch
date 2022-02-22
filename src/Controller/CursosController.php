<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cursos;
use Doctrine\Persistence\ManagerRegistry;


class CursosController extends AbstractController
{
    /**
     * @Route("/api/cursos", name="cursos_index", methods={"GET", "HEAD"})
     */
    public function cursos_index(ManagerRegistry $doctrine): Response
    {

        $cursos = $doctrine->getRepository(Cursos::class)->findAll();

        return $this->json([
            'data' => $cursos
        ]);
    }

    /**
     * @Route("/api/cursos/{cursoId}", name="cursos_show", methods={"GET", "HEAD"})
     */
    public function cursos_show($cursoId, ManagerRegistry $doctrine): Response
    {

        $curso = $doctrine->getRepository(Cursos::class)->find($cursoId);

        return $this->json([
            'data' => $curso
        ]);
    }

    /**
     * @Route("/api/cursos", name="cursos_create", methods={"POST"})
     */
    public function cursos_create(Request $request, ManagerRegistry $doctrine): Response
    {

        
        $data = json_decode($request->getContent(), true);

        $curso = new Cursos();
        $curso->setTitulo($data['titulo']);
        $curso->setDescricao($data['descricao']);
        $curso->setDataInicio(\DateTime::createFromFormat('Y-m-d', $data['data_inicio']));
        $curso->setDataFim(\DateTime::createFromFormat('Y-m-d', $data['data_fim']));
        $curso->setStatus($data['status']);

        $doctrine = $doctrine->getManager();
        $doctrine->persist($curso);
        $doctrine->flush();

        return $this->json([
            'data' => 'Curso criado com sucesso!'
        ]);
    }

    /**
     * @Route("/api/cursos/{cursoId}", name="cursos_update", methods={"PUT"})
     */
    public function cursos_update($cursoId, Request $request, ManagerRegistry $doctrine): Response
    {

        
        $data = json_decode($request->getContent(), true);

        $curso = $doctrine->getRepository(Cursos::class)->find($cursoId);

        if ($data['titulo']): $curso->setTitulo($data['titulo']); endif;
        if ($data['descricao']) : $curso->setDescricao($data['descricao']); endif;
        if ($data['data_inicio']) : $curso->setDataInicio(\DateTime::createFromFormat('Y-m-d', $data['data_inicio']));endif;
        if ($data['data_fim']) : $curso->setDataFim(\DateTime::createFromFormat('Y-m-d', $data['data_fim']));endif;
        if ($data['status']) : $curso->setStatus($data['status']);endif;

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Curso editado com sucesso!'
        ]);
    }

    /**
     * @Route("/api/cursos/{cursoId}", name="cursos_delete", methods={"DELETE"})
     */
    public function cursos_delete($cursoId, ManagerRegistry $doctrine): Response
    {

        $curso = $doctrine->getRepository(Cursos::class)->find($cursoId);

        $manager = $doctrine->getManager();
        $manager->remove($curso);
        $manager->flush();

        return $this->json([
            'data' => 'Curso removido com sucesso!'
        ]);
    }
}
