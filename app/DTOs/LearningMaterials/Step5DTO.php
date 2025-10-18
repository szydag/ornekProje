<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use CodeIgniter\HTTP\IncomingRequest;
use App\Exceptions\DtoValidationException;

final class Step5DTO
{
    public function __construct(
        /** @var array<string,bool> */
        public readonly array $checklist, // required_info/author_approval/writing_rules -> bool
        public readonly string $rules_ok,       // 'evet' | 'hayir'
        public readonly string $all_authors_ok, // 'evet' | 'hayir'
        public readonly ?string $description
    ) {}

    public static function fromRequest(IncomingRequest $r): self
    {
        $p = $r->getJSON(true) ?: $r->getPost();

        // checklist iki formatta gelebilir:
        // 1) ["required_info","author_approval","writing_rules"]
        // 2) {"required_info":true,"author_approval":true,"writing_rules":true}
        $rawChecklist = $p['checklist'] ?? [];
        $flags = [
            'required_info'  => false,
            'author_approval'=> false,
            'writing_rules'  => false,
        ];

        if (is_array($rawChecklist)) {
            // liste geldiyse
            if (array_is_list($rawChecklist)) {
                foreach ($rawChecklist as $k) {
                    if (isset($flags[$k])) $flags[$k] = true;
                }
            } else {
                // sözlük geldiyse
                foreach ($flags as $k => $_) {
                    $flags[$k] = !empty($rawChecklist[$k]);
                }
            }
        }

        $rulesOk       = ($flags['required_info'] && $flags['writing_rules']) ? 'evet' : 'hayir';
        $allAuthorsOk  = $flags['author_approval'] ? 'evet' : 'hayir';
        $desc          = trim((string)($p['editor_notes'] ?? $p['description'] ?? ''));

        // Basit doğrulama (istenirse genişlet)
        if (!$flags['required_info']) {
            throw new DtoValidationException(
                'Validation failed',
                ['checklist.required_info' => 'Zorunlu bilgiler onaylanmalı.']
            );                  
            
        }

        return new self(
            checklist: $flags,
            rules_ok: $rulesOk,
            all_authors_ok: $allAuthorsOk,
            description: $desc !== '' ? $desc : null
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'checklist'       => $this->checklist,
            'rules_ok'        => $this->rules_ok,
            'all_authors_ok'  => $this->all_authors_ok,
            'description'     => $this->description,
        ];
    }
}
