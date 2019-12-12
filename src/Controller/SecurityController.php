<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\RegistrationType;

use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\HttpFoundation\Session\Session;

class SecurityController extends AbstractController {

    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/profile/edit/{id}/{username}", name="security_account")
     */
    public function registration(User $user = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {

        if(!$user) {
            $user = new User();
        }

        $form = $this->createForm(registrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            if(!$user->getId()) { 

                $user->setCreatedAt(new \DateTime());
                $user->setRole("user");
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

        $this->addFlash(
            'logged',
            'Vous êtes connecté.'
        );

        return $this->render('security/login.html.twig');
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

    /**
     * @Route("/profile", name="my_account")
     */
    public function myaccount(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('blog/board.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/profile/delete/{id}", name="account_delete")
     */
    public function delete(User $user, ObjectManager $manager) {
        
        $manager->remove($user);
        $manager->flush();

        $session = $this->get('session');
        $session = new Session();

        $this->addFlash(
            'account_deleted',
            'Le compte a été supprimé'
        );

        $session->invalidate();

        return $this->redirectToRoute('user_deleted');
    }

    /**
     * @Route("profile/deleted", name="user_deleted")
     */
    public function userDeleted() {

        return $this->render('admin/delete.html.twig');
    }

    /**
     * @Route("/admin", name="security_admin")
     */
    public function admin() {

        return $this->render('admin/admin.html.twig');
    }

    /**
     * @Route("/admin/list/users", name="list_users")
     */
    public function listUsers(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);

    }

}
