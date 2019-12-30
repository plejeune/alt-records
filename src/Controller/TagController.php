<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\TagType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TagController extends AbstractController
{

    /**
     * @Route("/admin/tag",name="create_tag")
     */
    public function createTag(Request $request, ObjectManager $manager){
        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($tag);
            $manager->flush();

            $this->addFlash(
                'tag',
                'Le tag a été ajouté avec succès.'
            );

            return $this->redirectToRoute("security_admin");
        }

        return $this->render('/admin/create/createTag.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/tag/{name}",name="tag")
     */
    public function tagShow(TagRepository $tRepo, ArticleRepository $aRepo, $name, Request $request) {

        $tags = $tRepo->findAll();
        $articles = $aRepo->findAll();

        return $this->render('pages/tag.html.twig', [
            'tags' => $tags,
            'articles' => $articles,
            'name' => $name
        ]);
    }

}