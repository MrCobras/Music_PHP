<?php

namespace App\Controller;
use App\Entity\Song;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SongController extends AbstractController
{
    #[Route('/songs', name: 'songs_list')]
    public function list(): JsonResponse
    {
        $songs = [
            ['name' => 'Numb', 'author' => 'Linkin Park', 'genre' => 'Nu-Metal'],
            ['name' => 'One Step Closer', 'author' => 'Linkin Park', 'genre' => 'Nu-Metal'],
        ];

        return $this->json(
            $songs
        );
    }
    #[Route('/song/{id}', name: 'songs_desc', requirements: ['id'=>'\d+'])]
    public function view(int $id): JsonResponse
    {
        $songs = [
            ['name' => 'Numb', 'author' => 'Linkin Park', 'genre' => 'Nu-Metal'],
            ['name' => 'One Step Closer', 'author' => 'Linkin Park', 'genre' => 'Nu-Metal'],
        ];

        return $this->json(
            $songs[$id]
        );
    }
    #[Route('/track', name: 'app_track')]
    public function createTrack(EntityManagerInterface $entityManager): Response
    {
        $track = new Song();
        $track->setName('Faint');
        $track->setAuthor('Linkin Park');
        $track->setGenre('Nu-Metal');
//        dd($track);
        $entityManager->persist($track);
        $entityManager->flush();

        return new Response('Saved new track with id '.$track->getID());
    }
}