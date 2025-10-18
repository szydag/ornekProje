<?php
declare(strict_types=1);

namespace App\DTOs\Users;

use App\Exceptions\DtoValidationException;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\HTTP\IncomingRequest;

final class ProfileCompleteDTO
{
    public function __construct(
        public readonly string $phone,
        public readonly ?int $title_id,
        public readonly ?string $country_id,

        // institution choose
        public readonly ?int $institution_id,
        // toggles
        public readonly bool $no_institution,
        public readonly bool $add_institution,

        // new institution fields
        public readonly ?string $inst_language,
        public readonly ?string $inst_name,
        public readonly ?string $inst_type,
        public readonly ?string $inst_country,
        public readonly ?string $inst_city,
        public readonly ?string $inst_website,
    ) {
    }

    public static function fromRequest(\CodeIgniter\HTTP\IncomingRequest $r): self
    {
        // JSON gövdeyi oku; yoksa form post'a düş
        try {
            $p = $r->getJSON(true);
        } catch (HTTPException|\JsonException $e) {
            $p = null;
        }

        if (!is_array($p) || $p === []) {
            $p = $r->getPost();
        }

        $extractSingle = static function ($value) {
            if (is_array($value)) {
                $values = array_values($value);
                return $values[0] ?? null;
            }
            return $value;
        };

        $phoneValue = $extractSingle($p['phone'] ?? '');
        $phone = trim((string) $phoneValue);

        $titleRaw = $extractSingle($p['title'] ?? null);
        $title_id = ($titleRaw !== null && $titleRaw !== '') ? (int) $titleRaw : null;

        $countryRaw = $extractSingle($p['country'] ?? null);
        $country_id = ($countryRaw !== null && $countryRaw !== '') ? (string) $countryRaw : null;

        $institutionRaw = $extractSingle($p['institution'] ?? null);
        $institution_id = ($institutionRaw !== null && $institutionRaw !== '') ? (int) $institutionRaw : null;

        $noInstitutionRaw = $extractSingle($p['no_institution'] ?? 0);
        $addInstitutionRaw = $extractSingle($p['add_institution'] ?? 0);

        $no_inst = (bool) (int) $noInstitutionRaw;
        $add_inst = (bool) (int) $addInstitutionRaw;

        $inst_lang_raw = $extractSingle($p['institution_language'] ?? null);
        $inst_name_raw = $extractSingle($p['institution_name'] ?? null);
        $inst_type_raw = $extractSingle($p['institution_type'] ?? null);
        $inst_country_raw = $extractSingle($p['institution_country'] ?? null);
        $inst_city_raw = $extractSingle($p['institution_city'] ?? null);
        $inst_website_raw = $extractSingle($p['institution_website'] ?? null);

        $inst_lang = $inst_lang_raw !== null && $inst_lang_raw !== '' ? trim((string) $inst_lang_raw) : null;
        $inst_name = $inst_name_raw !== null && $inst_name_raw !== '' ? trim((string) $inst_name_raw) : null;
        $inst_type = $inst_type_raw !== null && $inst_type_raw !== '' ? trim((string) $inst_type_raw) : null;
        $inst_country = $inst_country_raw !== null && $inst_country_raw !== '' ? trim((string) $inst_country_raw) : null;
        $inst_city = $inst_city_raw !== null && $inst_city_raw !== '' ? trim((string) $inst_city_raw) : null;
        $inst_website = $inst_website_raw !== null && $inst_website_raw !== '' ? trim((string) $inst_website_raw) : null;

        $dto = new self(
            $phone,
            $title_id,
            $country_id,
            $institution_id,
            $no_inst,
            $add_inst,
            $inst_lang,
            $inst_name,
            $inst_type,
            $inst_country,
            $inst_city,
            $inst_website
        );
        $dto->validate();
        return $dto;
    }


    /** @throws DtoValidationException */
    /** @throws \App\Exceptions\DtoValidationException */

    public function validate(): void
    {
        $errors = []; // array<string,string>

        // Zorunlular
        if ($this->phone === '' || !preg_match('/^(0?\d{10})$/', $this->phone)) {
            $errors['phone'] = 'Lütfen geçerli bir telefon numarası girin (örn: 05551234567 veya 5551234567).';
        }

        if ($this->title_id === null || $this->title_id <= 0) {
            $errors['title'] = 'Ünvan zorunludur.';
        }
        if ($this->country_id === null || $this->country_id === '') {
            $errors['country'] = 'Ülke zorunludur.';
        }

        // Kurum mantığı (tek seçim)
        if ($this->no_institution && $this->add_institution) {
            $errors['institution_choice'] = 'Kurum seçeneklerinden yalnızca biri seçilebilir.';
        }

        if ($this->add_institution) {
            if ($this->institution_id !== null) {
                $errors['institution'] = 'Yeni kurum eklerken mevcut kurum seçilemez.';
            }
            if ($this->inst_name === null || $this->inst_name === '') {
                $errors['institution_name'] = 'Kurum adı zorunludur.';
            }
            if ($this->inst_type === null || $this->inst_type === '') {
                $errors['institution_type'] = 'Kurum türü zorunludur.';
            }
            if ($this->inst_country === null || $this->inst_country === '') {
                $errors['institution_country'] = 'Kurum ülkesi zorunludur.';
            }
        } elseif (!$this->no_institution) {
            if ($this->institution_id === null || $this->institution_id <= 0) {
                $errors['institution'] = 'Bir kurum seçin ya da “Kurum yok / Kurum eklemek istiyorum” seçeneklerinden birini işaretleyin.';
            }
        }

        if (!empty($errors)) {
            // Yeni Exception imzana uygun çağrı:
            throw new \App\Exceptions\DtoValidationException(
                'Profil tamamlama doğrulama hatası',
                $errors
            );
        }
    }


    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'title_id' => $this->title_id,
            'country_id' => $this->country_id,
            'institution_id' => $this->institution_id,
            'no_institution' => $this->no_institution,
            'add_institution' => $this->add_institution,
            'inst_language' => $this->inst_language,
            'inst_name' => $this->inst_name,
            'inst_type' => $this->inst_type,
            'inst_country' => $this->inst_country,
            'inst_city' => $this->inst_city,
            'inst_website' => $this->inst_website,
        ];
    }
}
