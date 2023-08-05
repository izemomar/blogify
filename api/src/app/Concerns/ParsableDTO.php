<?php

namespace App\Concerns;

trait ParsableDTO
{
    public static function fromRequest(array $data): static
    {
        $dto = new static();

        foreach ($data as $key => $value) {
            $dto->{$key} = $value;
        }

        return $dto;
    }

    public static function fromArray(array $data): static
    {
        $dto = new static();

        foreach ($data as $key => $value) {
            $dto->{$key} = $value;
        }

        return $dto;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
