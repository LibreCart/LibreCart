<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Form\AdminSetupType;
use App\Form\LoginFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/admin')]
class SecurityController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    private function adminExists(): bool 
    {
        return $this->userRepository->findOneByRole(UserRoleEnum::ROLE_ADMIN) ? true : false;
    }

    #[Route(path: '/login', name: 'app_admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if (!$this->adminExists()) {
            return $this->redirectToRoute('app_admin_setup');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/admin/login.html.twig', [
            'title' => 'Login',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_admin_logout')]
    public function logout(Security $security): Response
    {
        $security->logout();

        return new RedirectResponse('app_admin_login');
    }

    #[Route(path: '/setup', name: 'app_admin_setup')]
    public function register(Request $request): Response 
    {
        if ($this->adminExists()) {
            return $this->redirectToRoute('app_admin_login');
        }

        $user = new User();
        
        $form = $this->createForm(AdminSetupType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->addRole(UserRoleEnum::ROLE_ADMIN);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_login');
        }

        return $this->render('security/admin/setup.html.twig', [
            'title' => 'Setup Admin',
            'form' => $form->createView()
        ]);
    }
}
