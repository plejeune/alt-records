<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Entity\User;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="my_account")
     */
    public function myaccount(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('pages/account.html.twig', [
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
}
