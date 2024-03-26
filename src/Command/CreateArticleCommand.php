<?php

namespace App\Command;

use App\Entity\Article;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-article',
    description:'Create an article',
)]
class CreateArticleCommand extends Command
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('nbArticles', InputArgument::REQUIRED, 'Nombre d\'articles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $nbArticles = $input->getArgument('nbArticles');
        $io-> warning("Création de ".$nbArticles.' articles');
        
        if($nbArticles<1) return Command::FAILURE;

        for($compteur =0; $compteur < $nbArticles; $compteur++){
            $article = new Article;
            $article -> setTitre("Article numéro ".$compteur);
            $article -> setText("Hello world ".$compteur);
            $article -> setAuteur("Joris");
            $article -> setDate(new \DateTime());
            $this->entityManager->persist($article);
        }

        $this->entityManager->flush();
                
        $io-> success($compteur." articles crées !");

        return Command::SUCCESS;
    }
}
