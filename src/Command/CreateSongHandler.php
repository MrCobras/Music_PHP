<?php

namespace App\Command;

use App\CQRS\CommandHandler;
use App\Entity\Song;
use App\Repository\AuthorRepository;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateSongHandler implements CommandHandler
{
    public function __construct(
        private readonly GenreRepository $genreRepository,
        private readonly AuthorRepository $authorRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }
    public function __invoke(CreateSongCommand $command): void{
        $genre = $this->genreRepository->findOneBy(['id'=>$command->genre()]);

        $song = new Song();
        $song->setName($command->name());
        $song->setGenre($genre);
        foreach ($command->author() as $authorsIds) {
            $author = $this->authorRepository->find($authorsIds);

            if ($author) {
                $song->addAuthor($author);
            }
        }
        $this->entityManager->persist($song);
        $this->entityManager->flush();
    }
}