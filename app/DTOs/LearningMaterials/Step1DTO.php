<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;

final class Step1DTO
{
    public function __construct(
        public readonly int $content_type_id,
        /** @var int[] */
        public readonly array $topics,
        public readonly string $primary_language,
        public readonly string $title_tr,
        public readonly ?string $short_title_tr,
        public readonly ?string $keywords_tr,
        public readonly string $abstract_tr,
        public readonly ?string $title_en,
        public readonly ?string $short_title_en,
        public readonly ?string $keywords_en,
        public readonly ?string $abstract_en,
        public readonly int $course_id,
        public readonly bool $no_other_journal
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();

        // content_type_id hem "content_type_id" hem de "content_type" adlarıyla gelebilir
        $contentTypeId = (int)($p['content_type_id'] ?? $p['content_type'] ?? 0);

        // topics -> int[] normalizasyonu
        $topicsRaw = $p['topics'] ?? [];
        if (!is_array($topicsRaw)) {
            $topicsRaw = [$topicsRaw];
        }
        $topics = array_values(array_unique(array_map('intval', $topicsRaw)));

        // boole normalizasyonu
        $noOther = $p['no_other_journal'] ?? false;
        $noOther = filter_var($noOther, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        $noOther = (bool)($noOther ?? false);

        return new self(
            $contentTypeId,
            $topics,
            trim((string)($p['primary_language'] ?? 'tr')),
            trim((string)($p['title_tr'] ?? '')),
            self::nullOrTrim($p['short_title_tr'] ?? null),
            self::nullOrTrim($p['keywords_tr'] ?? null),
            trim((string)($p['abstract_tr'] ?? '')),
            self::nullOrTrim($p['title_en'] ?? null),
            self::nullOrTrim($p['short_title_en'] ?? null),
            self::nullOrTrim($p['keywords_en'] ?? null),
            self::nullOrTrim($p['abstract_en'] ?? null),
            (int)($p['course_id'] ?? 0),
            $noOther
        );
    }

    private static function nullOrTrim($v): ?string
    {
        if ($v === null) return null;
        $s = trim((string)$v);
        return $s === '' ? null : $s;
    }

    /** Basit kurallar — service içinde kullanılacak */
    public function rules(): array
    {
        return [
            'content_type_id'     => $this->content_type_id > 0,
            'topics'              => count($this->topics) > 0,
            'primary_language'    => in_array($this->primary_language, ['tr','en'], true),
            'title_tr'            => $this->title_tr !== '',
            'abstract_tr'         => mb_strlen($this->abstract_tr) >= 20, // örnek eşik
            'course_id'           => $this->course_id > 0,
        ];
    }

    /** Hata mesajları */
    public function errors(): array
    {
        $errs = [];
        foreach ($this->rules() as $field => $ok) {
            if (!$ok) {
                $errs[$field] = 'Geçersiz veya eksik alan';
            }
        }
        return $errs;
    }

    /** Controller’a dönecek temiz dizi */
    public function toArray(): array
    {
        return [
            'content_type_id'     => $this->content_type_id,
            'topics'              => $this->topics,
            'primary_language'    => $this->primary_language,
            'title_tr'            => $this->title_tr,
            'short_title_tr'      => $this->short_title_tr,
            'keywords_tr'         => $this->keywords_tr,
            'abstract_tr'         => $this->abstract_tr,
            'title_en'            => $this->title_en,
            'short_title_en'      => $this->short_title_en,
            'keywords_en'         => $this->keywords_en,
            'abstract_en'         => $this->abstract_en,
            'course_id'           => $this->course_id,
            'no_other_journal'    => $this->no_other_journal,
        ];
    }
}
