<?php

namespace App\Controller;
use App\Command\CreateSongCommand;
use App\Command\EditSongCommand;
use App\CQRS\CommandBus;
use App\Entity\Author;
use App\Entity\Genre;
use App\Entity\Song;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SongController extends AbstractController
{

    public function __construct(
        private readonly CommandBus          $commandBus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface  $validator
    )
    {
    }

    #[Route('/songs', methods: ['GET'])]
    public function list(EntityManagerInterface $entityManager): JsonResponse
    {
        $songs = $entityManager->getRepository(Song::class)->findall();

        return $this->json($songs, 200, [], ['groups' => ['song', 'author', 'genre']]);
    }

    #[Route('/songs', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $createSongRequest = $this->getInstanceFromRequest($request->getContent(), CreateSongRequest::class);

            $createSongCommand = new CreateSongCommand(
                name: $createSongRequest->name(),
                genre: $createSongRequest->genre(),
                authors: $createSongRequest->authors(),
            );
            $this->commandBus->dispatch($createSongCommand);
            return $this->json("Utwór został pomyslnie zakolejkowany do dodawania");
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            return new JsonResponse(['error' => $errorMessage], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/songs/{id}', methods: ['PUT'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        try {
            $editSongRequest = $this->getInstanceFromRequest($request->getContent(), CreateSongRequest::class);

            $editSongCommand = new EditSongCommand(
                name: $editSongRequest->name(),
                genre: $editSongRequest->genre(),
                authors: $editSongRequest->authors(),
            );
            $this->commandBus->dispatch($editSongCommand);
            return $this->json("Utwor został pomyslnie edytowany");
        } catch (Exception $exception) {
            $errorMessage = $exception->getMessage();
            return new JsonResponse(['error' => $errorMessage], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/songs/{id}', methods: ['GET'])]
    public function view(EntityManagerInterface $entityManager, int $id, SerializerInterface $serializer): JsonResponse
    {
        $song = $entityManager->getRepository(Song::class)->find($id);

        if (!$song) {
            throw $this->createNotFoundException(
                'No song found for id ' . $id
            );
        }

        return $this->json($song);
    }


    protected function getInstanceFromRequest(string $json, string $className): mixed
    {
        $data = $this->serializer->deserialize($json, $className, 'json');
        $errors = $this->validator->validate($data);

        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                throw new BadRequestException((string)$error->getMessage());
            }
        }

        return $data;
    }
}