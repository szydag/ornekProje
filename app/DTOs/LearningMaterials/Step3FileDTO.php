<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use App\Exceptions\DtoValidationException;

final class Step3FileDTO
{
    public function __construct(
        public readonly ?string $role,
        public readonly string $name,
        public readonly string $stored_path,
        public readonly ?string $mime,
        public readonly int $size,
        public readonly bool $is_primary,
        public readonly ?string $language,
        public readonly ?string $notes,
        public readonly ?string $temp_id,
        public readonly ?string $file_type = null,
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromArray(array $row): self
    {
        $role = isset($row['role']) ? (string) $row['role'] : null;
        $fileType = self::normalizeFileType($row['file_type'] ?? null, $role);

        return new self(
            $role,
            trim((string)($row['name'] ?? '')),
            trim((string)($row['stored_path'] ?? '')),
            isset($row['mime']) ? (string)$row['mime'] : null,
            (int)($row['size'] ?? 0),
            (bool)($row['is_primary'] ?? false),
            isset($row['language']) ? (string)$row['language'] : null,
            // ALIAS: UI/istemci "description" gönderebilirse bunu notes olarak kabul et
            isset($row['notes'])
                ? (string)$row['notes']
                : (isset($row['description']) ? (string)$row['description'] : null),
            isset($row['temp_id']) ? (string)$row['temp_id'] : null,
            $fileType
        );
    }

    private static function normalizeFileType(?string $value, ?string $role): ?string
    {
        $fileType = is_string($value) ? trim($value) : '';
        if ($fileType !== '') {
            return $fileType;
        }

        $role = is_string($role) ? trim($role) : '';
        if ($role === '') {
            return null;
        }

        return match ($role) {
            'full_text' => 'tam_metin',
            'copyright_form' => 'telif_hakki',
            default => 'ek_dosya',
        };
    }


    /** @return array<string,mixed> */
    public function validateRow(): array
    {
        $errors = [];
        if ($this->name === '')        $errors['name']        = 'Dosya adı zorunludur.';
        if ($this->stored_path === '') $errors['stored_path'] = 'Geçici dosya yolu zorunludur.';
        if ($this->size <= 0)          $errors['size']        = 'Dosya boyutu hatalı.';

        if (!empty($errors)) {
            throw new DtoValidationException('Step3File doğrulama hatası', $errors);
        }

        return [
            'role'       => $this->role,
            'name'       => $this->name,
            'stored_path'=> $this->stored_path,
            'mime'       => $this->mime,
            'size'       => $this->size,
            'is_primary' => $this->is_primary,
            'language'   => $this->language,
            'notes'      => $this->notes,
            'temp_id'    => $this->temp_id,
            'file_type'  => $this->file_type,
        ];
    }
}
