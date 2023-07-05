<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SongsController extends AbstractController
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
}