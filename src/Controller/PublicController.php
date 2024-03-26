<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublicController extends AbstractController
{
    //1 Article Repository à ajouer en autowire
    //2 On charge les articles
    //3 On passe les articles à la vue twig
    //4 On modifie la vue twig pour rendre les articles visibles

    //5 On crée une autre Route article (qui va afficher un article et ses commentaires)
    //6 On charge un article et ses Commentaires avec Article repository
    //7 On passe les infos à la vue
    //8 On modifie la vues

    //9 On crée un lien dans la vue TWIG acceuil, pour aller vers la route article

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
