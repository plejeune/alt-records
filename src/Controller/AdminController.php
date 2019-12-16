<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Entity\User;

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

        return $this->render('admin/users.html.twig', [
            'users' => $users
        ]);

    }
}
