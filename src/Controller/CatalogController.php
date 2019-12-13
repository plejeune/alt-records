<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\Common\Persistence\ObjectManager;

use App\Form\CommentType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;

class CatalogController extends AbstractController {

    /**
     * @Route("/catalogue", name="_catalogue")
     */
    public function index(ArticleRepository $repo, UserRepository $user) {

        $articles = $repo->findAll();
        
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'CatalogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home() {
        return $this->render('pages/home.html.twig');
    }

    /**
     * @Route("/about", name="about")
     */
    public function about() {
        return $this->render('pages/about.html.twig');
    }

    /**
    * @Route("/catalogue/item/new", name="blog_create")
    * @Route("/catalogue/item/edit/{id}", name="blog_edit")
    */
    public function form(Article $article = null, Request $request, ObjectManager $manager) {

        if(!$article) { 
            $article = new Article();
        }

        $form = $this->createFormBuilder($article)
                     ->add('author')
                     ->add('artist')
                     ->add('title')
                     ->add('album')
                     ->add('category', EntityType::class, [
                         'class' => Category::class,
                         'choice_label' => 'title'
                     ])
                     ->add('year')
                     ->add('content')
                     ->add('image')
                     ->add('video')
                     ->add('credits')
                     ->getForm();

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
    public function listCategory(ArticleRepository $repo, UserRepository $user) {

        $articles = $repo->findAll();

        return $this->render('pages/category.html.twig', [
            'controller_name' => 'CatalogController',
            'articles' => $articles
        ]);

    }

    
}
