<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\CommentType;
use App\Form\TagType;
use App\Form\ArticleType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

class CatalogController extends AbstractController {

    /**
     * @Route("/catalogue", name="catalogue_list")
     */
    public function index(ArticleRepository $repo) {

        $articles = $repo->findAll();
        
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'CatalogController',
            'articles' => $articles
        ]);
    }

    /**
    * @Route("/catalogue/item/new", name="blog_create")
    * @Route("/catalogue/item/edit/{id}", name="blog_edit")
    */
    public function form(Article $article = null, Request $request, ObjectManager $manager) {

        if(!$article) { 
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid()) {

            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());

                $this->addFlash(
                    'post',
                    'L\'élément a été ajouté avec succès.'
                );
            }

            else {
                $article->setModifiedAt(new \DateTime());
                $this->addFlash(
                    'repost',
                    'Les modifications ont été enregistrées.'
                );
            }

            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['slug' => $article->getSlug()]);
        }

        return $this->render('admin/create.html.twig', [
            'formArticle' => $form->createView(),
            'article' => $article,
            'editMode' => $article->getId() !== null
        ]);
    }
    
    /**
     * @Route("/catalogue/item/{slug}", name="blog_show")
     */
    public function show(Article $article, Request $request, ObjectManager $manager) {
        
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
            
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'comment',
                'Votre commentaire a été posté avec succès.'
            );

            return $this->redirectToRoute('blog_show', [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('pages/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);

    }

    /**
     * @Route("/catalogue/item/delete/{id}", name="item_delete")
     */
    public function delete(Article $article, ObjectManager $manager) {
        
        $manager->remove($article);
        $manager->flush();

        $this->addFlash(
            'item_deleted',
            'L\'élément a été supprimé.'
        );

        return $this->redirectToRoute('catalogue');
    }

    /**
     * @Route("catalogue/list", name="catalogue")
     */
    public function catalogueList(ArticleRepository $repo) {

        $articles = $repo->findAll();

        return $this->render('pages/catalogue.html.twig', [
            'controller_name' => 'CatalogController',
            'articles' => $articles
        ]);

    }

    
}
