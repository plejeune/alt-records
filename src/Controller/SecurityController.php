<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;

class SecurityController extends AbstractController {

    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/profile/edit/{id}/{username}", name="security_account")
     */
    public function registration(User $user = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        if(!$user) {
            $user = new User();
        }

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            if(!$user->getId()) { 

                $user->setCreatedAt(new \DateTime());
                $user->setRole("ROLE_USER");
                $user->setOnline("false");
                $user->setBlocked("false");
                /* $user->addRole("ROLE_USER"); */

                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'signin',
                    'Votre compte a été créé ! Vous pouvez à présent vous connecter.'
                );

                return $this->redirectToRoute('security_login');
            }

            else {
                $this->addFlash(
                    'resignin',
                    'Les modifications de vos informations personnelles ont été prises en compte.'
                );
            }

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('my_account', ['username' => $user->getUsername()]);
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'editMode' => $user->getId() !== null
        ]);

    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {

        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/action/deconnexion", name="logging_out")
     */
    public function logginOut(UserRepository $user, EntityManagerInterface $em) {

        $this->em = $em;

        $user = $this->getUser();
        $user->setOnline("false");

        $this->em->persist($user);
        $this->em->flush();

        return $this->render('security/logginout.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {
        
    }

    /**
     * @Route("/action/session/stop", name="logged_out")
     */
    public function loggedOut() {

        $this->addFlash(
            'loggedOut',
            'Vous êtes déconnecté. Nous espérons vous revoir bientôt !'
        );

        return $this->render('security/logout.html.twig');
        
    }

}
