<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Alunos;
use Doctrine\Persistence\ManagerRegistry;


class AlunosController extends AbstractController
{
    /**
     * @Route("/api/alunos", name="alunos_index", methods={"GET", "HEAD"})
     */
    public function alunos_index(ManagerRegistry $doctrine): Response
    {

        $alunos = $doctrine->getRepository(Alunos::class)->findAll();

        return $this->json([
            'data' => $alunos
        ]);
    }

    /**
     * @Route("/api/alunos/{alunoId}", name="alunos_show", methods={"GET", "HEAD"})
     */
    public function alunos_show($alunoId, ManagerRegistry $doctrine): Response
    {

        $aluno = $doctrine->getRepository(Alunos::class)->find($alunoId);

        return $this->json([
            'data' => $aluno
        ]);
    }

    /**
     * @Route("/api/alunos", name="alunos_create", methods={"POST"})
     */
    public function alunos_create(Request $request, ManagerRegistry $doctrine): Response
    {

        
        $data = json_decode($request->getContent(), true);

        $age = $this->getAge($data['data_nascimento']);

        if ($age < 16) {
            $response['error'] = 'O alunos deve ter mais de 16 anos';
            return $this->json($response, 404);
        }

        $aluno = new Alunos();
        $aluno->setNome($data['nome']);
        $aluno->setEmail($data['email']);
        $aluno->setDataNascimento(\DateTime::createFromFormat('Y-m-d', $data['data_nascimento']));
        $aluno->setStatus($data['status']);

        $doctrine = $doctrine->getManager();
        $doctrine->persist($aluno);
        $doctrine->flush();

        return $this->json([
            'data' => 'Aluno criado com sucesso!'
        ]);
    }

    /**
     * @Route("/api/alunos/{alunoId}", name="alunos_update", methods={"PUT"})
     */
    public function alunos_update($alunoId, Request $request, ManagerRegistry $doctrine): Response
    {

        
        $data = json_decode($request->getContent(), true);

        $aluno = $doctrine->getRepository(Alunos::class)->find($alunoId);

        if ($data['nome']) : $aluno->setTitulo($data['nome']);
        endif;
        if ($data['email']) : $aluno->setDescricao($data['email']);
        endif;
        if ($data['data_nascimento']) : $aluno->setDataInicio(\DateTime::createFromFormat('Y-m-d', $data['data_nascimento']));
        endif;
        if ($data['status']) : $aluno->setStatus($data['status']);
        endif;

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Aluno editado com sucesso!'
        ]);
    }

    /**
     * @Route("/api/alunos/{alunoId}", name="alunos_delete", methods={"DELETE"})
     */
    public function alunos_delete($alunoId, ManagerRegistry $doctrine): Response
    {

        $aluno = $doctrine->getRepository(Alunos::class)->find($alunoId);

        $manager = $doctrine->getManager();
        $manager->remove($aluno);
        $manager->flush();

        return $this->json([
            'data' => 'Aluno removido com sucesso!'
        ]);
    }


    private function getAge($date){
        $from = new \DateTime($date);
        $to   = new \DateTime('today');
        return $from->diff($to)->y;
    }
}
