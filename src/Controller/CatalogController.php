<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\ObjectManager;

use Knp\Component\Pager\PaginatorInterface;

use App\Form\CommentType;
use App\Form\ArticleType;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tag;
use App\Repository\TagRepository;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;


/**
 * @ORM\Entity(repositoryClass="App\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CatalogController extends AbstractController {

    /**
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(ArticleRepository $repo) {

        $articles = $repo->findAll();

        return $this->render('pages/catalogue.html.twig', [
            'controller_name' => 'CatalogController',
            'articles' => $articles
        ]);

    }

    /**
     * @Route("/catalogue/list", name="catalogue_list")
     */
    public function index(ArticleRepository $repo, Request $request, PaginatorInterface $paginator) {

        $articles = $paginator->paginate(
            $repo->findAllWithPagination(),
            $request->query->getInt('page', 1),
            8
        );
        
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
                $article->setModifiedAt(new \DateTime());

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
    public function show(Article $article, TagRepository $Trepo, Request $request, ObjectManager $manager) {
        
        $comment = new Comment();
        $tags = $Trepo->findAll();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setReported("false");
            
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
            'tags' => $tags,
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
     * @Route("/catalogue/comment/delete/{id}", name="comment_delete")
     */
    public function deleteCom(Comment $comment, ObjectManager $manager) {
        
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'com_deleted',
            'Le commentaire a été supprimé.'
        );

        $user = $this->getUser();
        $role = $user->getRole();

        if($role == "ROLE_ADMIN") { 
            return $this->redirectToRoute('security_admin');
        } else {
            return $this->redirectToRoute('my_account');
        }
    }

    /**
     * @Route("/catalogue/item/report/{id}", name="report_item")
     */
    public function reportItem(Article $article, ObjectManager $manager) {

        $article->setReported("true");

        $manager->persist($article);
        $manager->flush();

        $this->addFlash(
            'reported',
            'L\'élément a été signalé. Nous vous en remercions.'
        );

        return $this->redirectToRoute('catalogue');

    }

    /**
     * @Route("/catalogue/comment/report/{id}", name="report_com")
     */
    public function reportCom(Comment $comment, ObjectManager $manager) {

        $comment->setReported("true");

        $manager->persist($comment);
        $manager->flush();

        $this->addFlash(
            'reported',
            'L\'élément a été signalé. Nous vous en remercions.'
        );

        return $this->redirectToRoute('catalogue');

    }
    
}
