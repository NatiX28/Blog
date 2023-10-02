<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    public function recentArticles(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/recent.html.twig', [
            'articles' => $articleRepository->findRecent(),
        ]);
    }

    /* public function read (ArticleRepository $articleRepository, Article $article): Response
    {
        return $this->render('article/read.html.twig', [
            'article' => $articleRepository->findOneById($article->getId()),
        ]);
    }
    */

    #[Route('/search', name: 'app_article_search', methods: ['GET'])]
    public function search(ArticleRepository $articleRepository)
    {
        $form = $this->createFormBuilder(null,[
            'attr' => ['class' => 'form-inline'],
        ])
        ->setAction($this->generateUrl('app_article_search'))
        ->add('search',TextType::class, [
            'label' => false,
            'attr' => ['placeholder' => 'Rechercher...', 
                        'class' => 'form-control mr-sm-2']
        ])
        ->add('submit', SubmitType::class,[
            'attr' => [ 'class' => 'btn btn-outline-success my-2 my-sm-0']
        ])
        ->setMethod('GET')
        ->getForm();

        return $this->render('article/search_form.html.twig', [
            
        ]);
    }

    #[Route('/result', name: 'app_article_result', methods: ['GET'])]
    public function result(ArticleRepository $articleRepository, Request $request) : Response
    {
        $form = ($request->get('form'));
        $search = $form('search');
        $articles = $articleRepository->findBySearch($search);
        return this->render('')
    }

    
}
