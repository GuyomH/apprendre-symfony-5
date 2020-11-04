<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Security\LoginFormAuthenticator;
use App\Service\NavManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $pageList;
    private $routeList;

    public function __construct(NavManager $nav)
    {
        $this->pageList = $nav->pageList;
        $this->routeList = $nav->routeList;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/security/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $entityManager, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $user = new User; // On instancie un nouveau User
        $form = $this->createForm(RegistrationType::class, $user); // Création du formulaire
        $form->handleRequest($request); // Gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            // On encode le mot de passe
            $passwordEncoded = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordEncoded);
            // On attribue le rôle USER
            $user->setRoles(['role' =>'ROLE_USER']);
            // On enregistre l'utilisateur en base
            $entityManager->persist($user);
            $entityManager->flush();

            // Si l'enregistrement s'est bien passé, on authentifie le nouvel utilisateur
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $loginFormAuthenticator,
                'main' // nom du firewall (voir config/packages/security.yaml)
            );
        }

        return $this->render('security/register.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form' => $form->createView(), // Envoi du formulaire à la vue
        ]);
    }
}
