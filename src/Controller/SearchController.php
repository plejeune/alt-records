<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticleRepository;
use App\Entity\Article;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function searchBar(ArticleRepository $articleRepository) {
        $formBuilder = $this->createFormBuilder(null);
        
        $formBuilder->setAction($this->generateUrl('search_result'))
            ->add('query', TextType::class, [
                'attr' => ['placeholder' => 'Entrez le nom d\'un artiste... (Ex : Nirvana)']
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary']
            ]);
        
        $form = $formBuilder->getForm();

        return $this->render('search/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/result", name="search_result")
     */
    public function handleSearch(Request $request, ArticleRepository $articleRepository) {
        
        $query = $request->request->get('form')['query'];

        if($query) { 
            $articles = $articleRepository->findBy(
                array('artist' => $query)
            );
        }

        return $this->render('search/result.html.twig', [
            'articles' => $articles,
            'query' => $query
        ]);
        
    }

    /**
     * @Route("/searchbytitle", name="search_by_title")
     */
    public function searchBarByTitle(ArticleRepository $articleRepository) {
        $formBuilder = $this->createFormBuilder(null);
        
        $formBuilder->setAction($this->generateUrl('search_result_by_title'))
            ->add('query', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez le titre d\'une chanson... (Ex : Debaser)'
                ]
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        
        $form = $formBuilder->getForm();

        return $this->render('search/searchbytitle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/resultbytitle", name="search_result_by_title")
     */
    public function handleSearchByTitle(Request $request, ArticleRepository $articleRepository) {
        
        $query = $request->request->get('form')['query'];

        if($query) { 
            $articles = $articleRepository->findBy(
                array('title' => $query)
            );
        }

        return $this->render('search/result.html.twig', [
            'articles' => $articles,
            'query' => $query
        ]);
        
    }

    /**
     * @Route("/searchbyyear", name="search_by_year")
     */
    public function searchBarByYear(ArticleRepository $articleRepository) {
        $formBuilder = $this->createFormBuilder(null);
        
        $formBuilder->setAction($this->generateUrl('search_result_by_year'))
            ->add('query', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez une année... (Ex : 1999)'
                ]
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        
        $form = $formBuilder->getForm();

        return $this->render('search/searchbyyear.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/resultbyyear", name="search_result_by_year")
     */
    public function handleSearchByYear(Request $request, ArticleRepository $articleRepository) {
        
        $query = $request->request->get('form')['query'];

        if($query) { 
            $articles = $articleRepository->findBy(
                array('year' => $query)
            );
        }

        return $this->render('search/result.html.twig', [
            'articles' => $articles,
            'query' => $query
        ]);
        
    }
}
