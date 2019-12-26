<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Article;
use App\Form\TagType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;

class TagsController extends AbstractController
{

    /**
     * @Route("/admin/tag/{id}",name="createTag")
     * @param Request $request
     * @param EntityManager $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createTag(Article $article, Request $request, ObjectManager $manager, FormFactoryInterface $factory){
        $tag = new Tag();

        $form = $factory->create(TagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tag->setArticle($article);

            $manager->persist($tag);
            $manager->flush();
            return $this->redirectToRoute("tag",[
                'id' => $tag->getId(),
                'article' => $article
            ]);
        }

        return $this->render('/admin/createTag.html.twig',[
            'form' => $form->createView(),
            'id' => $article
        ]);

    }

    /**
     * @Route("/tag/{id<\d+>}",name="tag", methods={"GET"})
     */
    public function tag(Tag $tag, ArticleRepository $articleRepository){
        $articles = $articleRepository->findByTags([$tag]);
        return $this->render('pages/tag.html.twig', [
            'tag' => $tag, 
            'articles'=> $articles,
            'editMode' => $article->getId() !== null
        ]);
    }

}