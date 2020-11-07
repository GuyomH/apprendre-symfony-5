<?php

namespace App\Controller;

use App\Entity\Token;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Security\LoginFormAuthenticator;
use App\Services\NavManager;
use App\Services\TokenSender;
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
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder, TokenSender $tokenSender)
    {
        $user = new User; // On instancie un nouveau User
        $form = $this->createForm(RegistrationType::class, $user); // Création du formulaire dont les données seront associées à $user
        $form->handleRequest($request); // Gestion de la requête

        if($form->isSubmitted() && $form->isValid())
        {
            // On encode le mot de passe
            $passwordEncoded = $userPasswordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordEncoded);

            // On attribue le rôle USER
            $user->setRoles(['role' =>'ROLE_USER']);

            // On enregistre le token et le user en base
            $token = new Token($user);
            $entityManager->persist($token);
            $entityManager->flush();

            // On envoie le mail de confirmation et on notifie
            $tokenSender->sendToken($user, $token);

            $this->addFlash(
                'notice',
                'Un email vous a été envoyé, veuillez confirmer votre inscription en cliquant sur le lien'
            );

            return $this->redirectToRoute('index');
        }

        return $this->render('security/register.html.twig', [
            'page_list' => $this->pageList,
            'route_list' => $this->routeList,
            'form' => $form->createView(), // Envoi du formulaire à la vue
        ]);
    }

    /**
     * @Route("/confirmation/{value}", name="token_validation")
     */
    public function tokenValidation(Token $token, EntityManagerInterface $manager, GuardAuthenticatorHandler $guardAuthenticatorHandler, LoginFormAuthenticator $loginFormAuthenticator, Request $request)
    {
        $user = $token->getUser();

        // Si le token a déjà été validé
        if($user->isEnable())
        {
            $this->addFlash(
                'notice',
                'Le token est déjà validé !'
            );

            return $this->redirectToRoute('registration');
        }

        // Si le token est valide
        if($token->isValid())
        {
            // On met la propriété enable à true et ...
            $user->setEnable(true);
            $manager->flush();

            // ... on authentifie l'utilisateur et on le met en session
            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $loginFormAuthenticator,
                'main' // nom du firewall (voir config/packages/security.yaml)
            );
        }

        // Sinon, on supprime de la base le token et par effet de cascade le user, puis on notifie
        $manager->remove($token);
        $manager->flush();

        $this->addFlash(
            'notice',
            'Trop tard, Le token est expiré ! Veuillez vous inscrire à nouveau !'
        );

        return $this->redirectToRoute('registration');
    }
}
