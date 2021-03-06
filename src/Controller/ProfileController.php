<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\CommentRepository;
use App\Entity\Comment;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="my_account")
     */
    public function myAccount(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('pages/account.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/profile/mycomments", name="my_comments")
     */
    public function myComments(CommentRepository $repo) {

        $comments = $repo->findAll();

        return $this->render('pages/mycomments.html.twig', [
            'comments' => $comments
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

        return $this->render('admin/delete/delete.html.twig');
    }
}
