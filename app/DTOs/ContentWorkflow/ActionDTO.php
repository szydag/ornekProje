<?php
declare(strict_types=1);

namespace App\DTOs\ContentWorkflow;

use App\Exceptions\DtoValidationException;

final class ActionDTO
{
    public string $action_code;          // onay | red | revizyon | onizleme | yayinla | revizyonok
    /** @var int[] */
    public array $reviewer_ids = [];     // sadece onay (on_inceleme -> korhakemlik) anında

    public static function fromArray(array $p): self
    {
        $dto = new self();
        $dto->action_code  = trim((string)($p['action_code'] ?? ''));
        $ids               = $p['reviewer_ids'] ?? [];
        $dto->reviewer_ids = is_array($ids) ? array_values(array_filter(array_map('intval', $ids))) : [];
        $dto->validate();
        return $dto;
    }

    private function validate(): void
    {
        $valid = ['onay','red','revizyon','onizleme','yayinla','revizyonok'];
        if ($this->action_code === '' || !in_array($this->action_code, $valid, true)) {
            throw new DtoValidationException('Geçersiz action_code.');
        }
        // reviewer_ids sadece ilk onayda anlamlı; servis içinde state’e göre tekrar kontrol edeceğiz.
    }
}
