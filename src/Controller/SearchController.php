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
        
        $formBuilder->setAction($this->generateUrl('handleSearch'))
            ->add('query', TextType::class, [
                'attr' => [
                    'placeholder' => 'Entrez un artiste, un titre, une année...'
                ]
            ])
            ->add('rechercher', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ]);
        
        $form = $formBuilder->getForm();

        return $this->render('pages/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/handleSearch", name="handleSearch")
     */
    public function handleSearch(Request $request, ArticleRepository $articleRepository) {
        
        $query = $request->request->get('form')['query'];

        if($query) { 
            $articles = $articleRepository->findBy(
                array('year' => $query)
            );
        }

        return $this->render('pages/result.html.twig', [
            'articles' => $articles,
            'query' => $query
        ]);
        
    }
}
