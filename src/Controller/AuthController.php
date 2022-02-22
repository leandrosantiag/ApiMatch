<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class AuthController extends AbstractController
{

    /**
     * @Route("/api/login", name="login", methods={"POST"})
     */
    public function login(JWTTokenManagerInterface $jwt, UserRepository $userRepo, UserPasswordHasherInterface $encoder, Request $request): Response
    {
        $response = [
            'status' => false,
            'message' => '',
            'token' => '',
        ];

        $parameter = json_decode($request->getContent(), true);

        $email = trim(strip_tags($parameter['username']));
        $password = trim(strip_tags($parameter['password']));

        $queryData = ['email' => $email];
        $user = $userRepo->findOneBy($queryData);

        if (!$user || !$encoder->isPasswordValid($user, $password)) {
            $response['message'] = 'Usuário ou senha incorreto.';
        }
        else if ($user->getNivel() != 1) {
            $response['message'] = 'Apenas administradores podem acessar a api';
        } else {
            $response['status'] = true;
            $response['message'] = 'Logado!';
            $response['token'] = $jwt->create($user);
        }

        return $this->json($response);
    }
    /**
     * @Route("/api/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordHasherInterface $encoder, ManagerRegistry $registry): Response
    {
        $response = [
            'status' => false,
            'message' => '',
        ];

        $parameter = json_decode($request->getContent(), true);

        $email = $parameter["username"];
        $password = $parameter["password"];

        // dd($parameter);

        if (empty($email) || empty($password)) {
            $response['message'] = "Prencha o usuario e senha";
            return $this->json($response);
        }

        try {
            $user = new User();

            $user->setPassword($encoder->hashPassword($user, $password));
            $user->setEmail($email);
            $user->setNivel(1);

            $registry->getManager()->persist($user);
            $registry->getManager()->flush();

            $response['status'] = true;
            $response['message'] = sprintf('Usuário %s criado com sucesso!', $user->getUsername());

            return $this->json($response);
        } catch (UniqueConstraintViolationException $e) {

            $response['message'] = "Duplicado";

            return $this->json($response);
        } catch (Exception $e) {
            $response['message'] = "Unknown Error";
            return $this->json($response);
        }
    }

}
