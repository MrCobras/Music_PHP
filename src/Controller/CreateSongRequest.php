<?php

namespace App\Controller;

use Symfony\Component\Uid\Uuid;
use App\Domain\Vacation\Enum\VacationTypes;
use App\Domain\Vacation\ValueObject\VacationType;
use Symfony\Component\Validator\Constraints as Assert;
class CreateSongRequest
{
    public function __construct(

        #[Assert\NotNull(message: 'Nazwa utworu nie może być pusta')]
        #[Assert\Type(type: "string", message: 'Nieprawidłowy format nazwy')]
        #[Assert\Length(null, 1, 128)]
        public readonly ?string $name,

        #[Assert\NotNull(message: 'Gatunek nie może być pusty')]
        #[Assert\Type(type: "int", message: 'Nieprawidłowy format gatunku')]
        public readonly int     $genre,

        #[Assert\Type(type: "array", message: 'Nieprawidłowy typ autora')]
        public readonly ?array $authors
    ){
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function genre(): int
    {
        return $this->genre;
    }

    public function authors(): ?array
    {
        return $this->authors;
    }
}