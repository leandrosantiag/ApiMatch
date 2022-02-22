<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Matriculas;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Cursos;
use App\Entity\Alunos;

class MatriculasController extends AbstractController
{
    /**
     * @Route("/api/matriculas", name="matriculas_index", methods={"GET", "HEAD"})
     */
    public function matriculas_index(ManagerRegistry $doctrine): Response
    {

        $matriculas = $doctrine->getRepository(Matriculas::class)->findAll();

        return $this->json([
            'data' => $matriculas
        ]);
    }

    /**
     * @Route("/api/matriculas/{matriculaId}", name="matriculas_show", methods={"GET", "HEAD"})
     */
    public function matriculas_show($matriculaId, ManagerRegistry $doctrine): Response
    {

        $matricula = $doctrine->getRepository(Matriculas::class)->find($matriculaId);

        return $this->json([
            'data' => $matricula
        ]);
    }

    /**
     * @Route("/api/matriculas", name="matriculas_create", methods={"POST"})
     */
    public function matriculas_create(Request $request, ManagerRegistry $doctrine, UserInterface $user): Response
    {

        
        $data = json_decode($request->getContent(), true);

        if (!$data['curso']) {
            $response['message'] = 'Escolha pelo curso para continuar.';
        }
        else if (!$data['aluno']) {
            $response['message'] = 'Informe o aluno para continuar.';
        } else {

            $curso = $doctrine->getRepository(Cursos::class)->find($data['curso']);
            $aluno = $doctrine->getRepository(Alunos::class)->find($data['aluno']);

            if (!$curso) {
                $response['message'] = 'O curso escolhido não existe.';
            } else if (!$aluno) {
                $response['message'] = 'O aluno informado não existe.';
            } else {

                $contaMatriculasAluno = $doctrine->getRepository(Matriculas::class)->createQueryBuilder('a')
                    ->andWhere('a.curso_id = ' . $data['curso'] . '')
                    ->andWhere('a.aluno_id = ' . $data['aluno'] . '')
                    ->select('count(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult();

                $contaMatriculas = $doctrine->getRepository(Matriculas::class)->createQueryBuilder('a')
                    ->andWhere('a.curso_id = ' . $data['curso'] . '')
                    ->select('count(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult();

                if ($aluno->getStatus() != "1") {
                    $response['message'] = 'Este aluno está inativo e não pode receber matriculas.';
                } else if ($curso->getStatus()  != "1") {
                    $response['message'] = 'Este curso não está mais dsponível para matricula.';
                } else if ($contaMatriculasAluno > 0) {
                    $response['message'] = 'Este aluno já está matriculado no curso.';
                } else if ($contaMatriculas >= 10) {
                    $response['message'] = 'Este curso já esgotou o número de vagas.';
                } else {

                    $userId = $user->getId();

                    $matricula = new Matriculas();
                    $matricula->setCursoid($data['curso']);
                    $matricula->setAlunoid($data['aluno']);
                    $matricula->setUserid($userId);
                    $matricula->setDataMatricula(\DateTime::createFromFormat('Y-m-d', date("Y-m-d")));

                    $doctrine = $doctrine->getManager();
                    $doctrine->persist($matricula);
                    $doctrine->flush();

                    $response['message'] = 'Matrícula realizada com sucesso!';
                }

            }

            

        }
        

        return $this->json($response);
    }

    /**
     * @Route("/api/matriculas/{matriculaId}", name="matriculas_update", methods={"PUT"})
     */
    public function matriculas_update($matriculaId, Request $request, ManagerRegistry $doctrine): Response
    {

        $data = json_decode($request->getContent(), true);
        $matricula = $doctrine->getRepository(Matriculas::class)->find($matriculaId);

        if ($data['curso']) : $matricula->setCursoid($data['curso']); endif;
        if ($data['aluno']) : $matricula->setAlunoid($data['aluno']); endif;

        $manager = $doctrine->getManager();
        $manager->flush();

        return $this->json([
            'data' => 'Matricula editada com sucesso!'
        ]);
    }

    /**
     * @Route("/api/matriculas/{matriculaId}", name="matriculas_delete", methods={"DELETE"})
     */
    public function matriculas_delete($matriculaId, ManagerRegistry $doctrine): Response
    {

        $matricula = $doctrine->getRepository(Matriculas::class)->find($matriculaId);

        $manager = $doctrine->getManager();
        $manager->remove($matricula);
        $manager->flush();

        return $this->json([
            'data' => 'Matricula removida com sucesso!'
        ]);
    }

}
