<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Article;
use App\Entity\Tag;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="security_admin")
     */
    public function admin(UserRepository $Urepo, ArticleRepository $Arepo, CommentRepository $Crepo) {

        $users = $Urepo->findAll();
        $articles = $Arepo->findAll();
        $comments = $Crepo->findAll();

        return $this->render('admin/admin.html.twig', [
            'users' => $users,
            'articles' => $articles,
            'comments' => $comments
        ]);
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
     * @Route("/admin/list/blockedusers", name="blocked_users")
     */
    public function blockedUsers(UserRepository $repo) {

        $users = $repo->findAll();

        return $this->render('admin/list/blockedUsers.html.twig', [
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

        return $this->render('admin/delete/userdelete.html.twig');
    }

    /**
     * @Route("/admin/block/user/{id}", name="block_user")
     */
    public function blockUser(User $user, ObjectManager $manager) {

        $user->setBlocked("true");

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'blocked',
            'L\'utilisateur a été blacklisté.'
        );

        return $this->redirectToRoute('security_admin');

    }

    /**
     * @Route("/admin/unblock/user/{id}", name="unblock_user")
     */
    public function unblockUser(User $user, ObjectManager $manager) {

        $user->setBlocked("false");

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'unblocked',
            'L\'utilisateur n\'est plus blacklisté.'
        );

        return $this->redirectToRoute('security_admin');

    }

    /**
     * @Route("/admin/promote/user/{id}", name="promote_user")
     */
    public function promoteUser(User $user, ObjectManager $manager) {

        $user->setRole("ROLE_ADMIN");

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'promote',
            'L\'utilisateur a été promu au rôle ADMIN.'
        );

        return $this->redirectToRoute('security_admin');

    }

    /**
     * @Route("/admin/demote/user/{id}", name="demote_user")
     */
    public function demoteUser(User $user, ObjectManager $manager) {

        $user->setRole("ROLE_USER");

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'demote',
            'L\'utilisateur a été rétrogradé au rôle USER.'
        );

        return $this->redirectToRoute('security_admin');

    }
}
