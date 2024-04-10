<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\Type\TaskType;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;

class PublicController extends AbstractController
{

    protected ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();


        return $this->render('public/index.html.twig', [
            'articles' => $articles
        ]);
    }
    #[Route('/article/{id}', name: 'app_article')]
    public function article(int $id): Response
    {

        $article = $this->articleRepository->find($id);
        $commentaires = $article->getComments();

        return $this->render('public/article.html.twig', [
            'article' => $article,
            'comments' => $commentaires
        ]);
    }
    
}
