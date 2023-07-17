<?php

namespace App\Command;

use App\CQRS\Command;

class EditSongCommand implements Command
{
    public function __construct(
        private readonly ?string $name,
        private readonly int     $genre,
        private readonly ?array  $authors
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

    public function author(): array
    {
        return $this->authors ?? [];
    }
}