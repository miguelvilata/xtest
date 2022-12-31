<?php

declare(strict_types=1);

namespace App\ValueObjects;

use Ramsey\Uuid\Uuid;

final class UserName
{
    private readonly ?string $value;

    public function __construct(string $value = null)
    {
        $value = $value ?? Uuid::uuid4()->toString();

        if ((strlen($value) > 36) || (strlen($value) < 3)) {
            throw new \InvalidArgumentException('Non valid user name provided');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value ?? 'hola';
    }
}
