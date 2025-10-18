<?php
declare(strict_types=1);

namespace App\DTOs\ContentWorkflow;

use App\Exceptions\DtoValidationException;

final class AssignEditorDTO
{
    public int $editor_id;

    public static function fromArray(array $p): self
    {
        $dto = new self();
        $dto->editor_id = (int)($p['editor_id'] ?? 0);
        if ($dto->editor_id <= 0) {
            throw new DtoValidationException('Geçersiz editor_id.');
        }
        return $dto;
    }
}
