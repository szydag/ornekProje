<?php
declare(strict_types=1);

namespace App\DTOs\ContentWorkflow;

use App\Exceptions\DtoValidationException;

final class AssignReviewersDTO
{
    /** @var int[] */
    public array $reviewer_ids = [];

    public static function fromArray(array $p): self
    {
        $dto = new self();
        $ids = $p['reviewer_ids'] ?? [];
        $dto->reviewer_ids = is_array($ids) ? array_values(array_filter(array_map('intval', $ids))) : [];
        if (count($dto->reviewer_ids) < 1) {
            throw new DtoValidationException('En az bir hakem seçmelisiniz.');
        }
        return $dto;
    }
}
