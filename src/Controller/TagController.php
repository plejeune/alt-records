<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\TagType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController {

    /**
     * @Route("/admin/tag/{id}",name="createTag")
     */
    public function createTag(Article $article, Request $request, EntityManagerInterface $em) {

        $tag = new Tag();

        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tag->setArticle($article);
            $em->persist($tag);
            $em->flush();
            return $this->redirectToRoute("tag",['id'=> $tag->getId()]);
        }

        return $this->render('/admin/tagCreate.html.twig', [
            'id' => $article->getId(),
            'tagForm'=> $form->createView()
        ]);

    }

    /**
     * @Route("/tag/{id<\d+>}",name="tag")
     */
    public function tag(Tag $tag, ArticleRepository $repo) {

        $posts = $repo->findByTags([$tag]);
        return $this->render('pages/tagShow.html.twig', ['tag' => $tag, 'posts'=> $posts]);
    }

}