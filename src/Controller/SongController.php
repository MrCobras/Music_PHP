<?php

namespace App\Controller;
use App\Entity\Genre;
use App\Entity\Song;
use App\Repository\GenreRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;


class SongController extends AbstractController
{
    #[Route('/songs', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $songs = $entityManager->getRepository(Song::class)->findall();

        return $this->json(
            $songs
        );
    }
    #[Route('/songs', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager): Response
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(),true);
        $genre = $entityManager->getRepository(Genre::class);
        $song = new Song;
        $name = $data["name"];
        $author = $data["author"];
        $genreId = $data["genre"];
        $genre = $genre->find($genreId);
        $song->setName($name);
        $song->setAuthor($author);
        $song->setGenre($genre);
        $entityManager->persist($song);
        $entityManager->flush();

        return new Response('New song has been added: ID '.$song->getId().' '.$song->getName().' - '.$song->getAuthor());
    }
    #[Route('/songs/{id}', methods: ['PUT'])]
    public function edit(EntityManagerInterface $entityManager, int $id): Response
    {
        $request = Request::createFromGlobals();
        $data = json_decode($request->getContent(),true);
        $song = $entityManager->getRepository(Song::class)->find($id);
        $genre = $entityManager->getRepository(Genre::class);
        $name = $data["name"];
        $author = $data["author"];
        $genreId = $data["genre"];
        $genre = $genre->find($genreId);
        $song->setName($name);
        $song->setAuthor($author);
        $song->setGenre($genre);
        $entityManager->persist($song);
        $entityManager->flush();

        return new Response('Song has been edited to: ID '.$song->getId().' '.$song->getName().' - '.$song->getAuthor());
    }
    #[Route('/songs/{id}', methods: ['GET'])]
    public function view(EntityManagerInterface $entityManager, int $id, SerializerInterface $serializer): JsonResponse
    {
        $song = $entityManager->getRepository(Song::class)->find($id);

        if (!$song){
            throw $this->createNotFoundException(
                'No song found for id '.$id
            );
        }

            return $this->json($song);
    }
}