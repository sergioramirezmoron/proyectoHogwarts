<?php

namespace App\Controller;

use App\Repository\EnrollmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EnrollmentRepository $enrollmentRepository): Response
    {
        $user = $this->getUser();
        $matriculas = [];

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        if (in_array('ROLE_STUDENT', $user->getRoles())) {
            $matriculas = $enrollmentRepository->findBy(['student' => $user]);
        }

        return $this->render('main/index.html.twig', [
            'matriculas' => $matriculas,
        ]);
    }
}
