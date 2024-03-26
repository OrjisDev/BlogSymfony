<?php

namespace App\Command;

use App\Entity\Commentaire;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Comment;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-comment',
    description: 'Add a short description for your command',
)]
class CreateCommentCommand extends Command
{
    protected ArticleRepository $articleRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, 
                                ArticleRepository $articleRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->articleRepository = $articleRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('nb_commentaire', InputArgument::REQUIRED, 'Nombre de commentaire')
            ->addArgument('id_article', InputArgument::REQUIRED, 'Id de l\'article')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $idArticle = $input->getArgument('id_article');
        $article = $this->articleRepository->find($idArticle);

        if(!$article){
            $io-> error('Imposible de trouver l\'article '.$idArticle);
            return Command::FAILURE;
        }

        $nbCommentaires = $input->getArgument('nb_commentaire');

        for($compteur =0; $compteur < $nbCommentaires; $compteur++){
            $io->comment('Création commentaire '.$compteur);
            $commentaire = new Commentaire();
            $commentaire->setTexte('Commentaire '.$compteur);
            $commentaire->setAuteur('Joris');
            $commentaire->setDate(new \DateTime());
            $commentaire->setArticle($article);
            $this->entityManager->persist($commentaire);
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
