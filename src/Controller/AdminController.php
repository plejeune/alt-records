<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\ArticleRepository;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Article;

class AdminController extends AbstractController
{
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

        return $this->render('admin/list/users.html.twig', [
            'users' => $users
        ]);

    }

    /**
     * @Route("/admin/list/onlineusers", name="online_users")
     */
    public function onlineUsers(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('admin/list/onlineUsers.html.twig', [
            'users' => $users
        ]);

    }

    /**
     * @Route("/admin/list/admins", name="list_admins")
     */
    public function listAdmins(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('admin/list/admins.html.twig', [
            'users' => $users
        ]);

    }

    /**
     * @Route("/admin/list/items", name="list_items")
     */
    public function listItems(ArticleRepository $repo) {

        $articles = $repo->findAll();

        return $this->render('admin/list/items.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/admin/list/comments", name="list_comments")
     */
    public function listComments(CommentRepository $repo) {

        $comments = $repo->findAll();

        return $this->render('admin/list/comments.html.twig', [
            'comments' => $comments
        ]);

    }

    /**
     * @Route("/admin/list/items/reported", name="reported_items")
     */
    public function reportedListItems(ArticleRepository $repo) {

        $articles = $repo->findAll();

        return $this->render('admin/list/reportedItem.html.twig', [
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/admin/list/comments/reported", name="reported_comments")
     */
    public function reportedListComments(CommentRepository $repo) {

        $comments = $repo->findAll();

        return $this->render('admin/list/reportedComment.html.twig', [
            'comments' => $comments
        ]);

    }

    /**
     * @Route("/admin/delete/user/{id}", name="user_delete")
     */
    public function userDelete(User $user, ObjectManager $manager) {
        
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'account_deleted',
            'Le compte a été supprimé.'
        );

        return $this->redirectToRoute('a_user_deleted');
    }

    /**
     * @Route("admin/user/deleted", name="a_user_deleted")
     */
    public function aUserDeleted() {

        return $this->render('admin/userdelete.html.twig');
    }
}
