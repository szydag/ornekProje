<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

final class DtoValidationException extends RuntimeException
{
    /** @var array<string,string> */
    private array $errors = [];

    /**
     * @param string $message Genel hata mesajı
     * @param array<string,string> $errors Alan-bazlı hata listesi
     */
    public function __construct(string $message = 'Validation failed', array $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    /**
     * Alan bazlı hataları döndürür
     * 
     * @return array<string,string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
