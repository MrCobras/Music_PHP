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
use Symfony\Component\Serializer\SerializerInterface;


class SongController extends AbstractController
{
    #[Route('/songs', name: 'songs_list')]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $songs = $entityManager->getRepository(Song::class)->findall();

        return $this->json(
            $songs
        );
    }
    #[Route('/track', name: 'app_track')]
    public function createTrack(EntityManagerInterface $entityManager): Response
    {
        $track = new Song();
        $track->setName('Faint');
        $track->setAuthor('Linkin Park');
        $entityManager->persist($track);
        $entityManager->flush();

        return new Response('Saved new track with id '.$track->getID());
    }
    #[Route('/song/{id}', name: 'songs_desc')]
    public function view(EntityManagerInterface $entityManager, int $id, SerializerInterface $serializer): JsonResponse
    {
        $songs = $entityManager->getRepository(Song::class)->find($id);

        if (!$songs){
            throw $this->createNotFoundException(
                'No song found for id '.$id
            );
        }

            return $this->json($songs);
    }
}