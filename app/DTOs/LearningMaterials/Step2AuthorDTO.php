<?php
declare(strict_types=1);

namespace App\DTOs\LearningMaterials;

use App\Exceptions\DtoValidationException;

final class Step2AuthorDTO
{
    public function __construct(
        public readonly string $type, // author|translator
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        public readonly bool $is_corresponding,
        public readonly int $order,
        public readonly ?string $affiliation = null,
        public readonly ?int $affiliation_id = null,
        public readonly ?string $orcid = null,
        public readonly ?int $user_id = null,
        public readonly ?int $title_id = null,
        public readonly ?string $title = null,
        public readonly ?string $phone = null,
        public readonly ?int $country_id = null,
        public readonly ?string $country = null,
        public readonly ?string $city = null,
        public readonly ?string $address = null
    ) {}

    /** @param array<string,mixed> $row */
    public static function fromArray(array $row): self
    {
        $type = strtolower((string)($row['type'] ?? 'author'));
        $firstName = trim((string)($row['first_name'] ?? ''));
        $lastName = trim((string)($row['last_name'] ?? ''));
        $email = trim((string)($row['email'] ?? ''));
        $isCorresponding = (bool)($row['is_corresponding'] ?? false);
        $order = (int)($row['order'] ?? 0);
        $affiliation = $row['affiliation'] ?? null;
        $affiliationId = self::nullablePositiveInt($row['affiliation_id'] ?? null);
        $orcid = $row['orcid'] ?? null;
        $userId = self::nullablePositiveInt($row['user_id'] ?? null);
        $titleId = self::nullablePositiveInt($row['title_id'] ?? null);
        $title = $row['title'] ?? null;
        $phone = $row['phone'] ?? null;
        $countryId = self::nullablePositiveInt($row['country_id'] ?? ($row['country_code'] ?? null));
        $country = $row['country'] ?? null;
        $city = $row['city'] ?? null;
        $address = $row['address'] ?? null;

        return new self(
            $type,
            $firstName,
            $lastName,
            $email,
            $isCorresponding,
            $order,
            $affiliation,
            $affiliationId,
            $orcid,
            $userId,
            $titleId,
            $title,
            $phone,
            $countryId,
            $country,
            $city,
            $address
        );
    }

    private static function nullablePositiveInt($value): ?int
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $value = trim($value);
            if ($value === '') {
                return null;
            }
        }

        if (!is_numeric($value)) {
            return null;
        }

        $int = (int) $value;
        return $int > 0 ? $int : null;
    }

    /** @return array<string,mixed> */
    public function validate(): array
    {
        $errors = [];
        if ($this->first_name === '') $errors['first_name'] = 'Ad zorunludur.';
        if ($this->last_name === '')  $errors['last_name']  = 'Soyad zorunludur.';
        if ($this->email === '')      $errors['email']      = 'E-posta zorunludur.';
        if ($this->order <= 0)        $errors['order']      = 'Yazar sırası hatalı.';

        if (!empty($errors)) {
            throw new DtoValidationException('Step2Author doğrulama hatası', $errors);
        }

        return [
            'type'             => $this->type,
            'first_name'       => $this->first_name,
            'last_name'        => $this->last_name,
            'email'            => $this->email,
            'is_corresponding' => $this->is_corresponding,
            'order'            => $this->order,
            'affiliation'      => $this->affiliation,
            'affiliation_id'   => $this->affiliation_id,
            'orcid'            => $this->orcid,
            'user_id'          => $this->user_id,
            'title_id'         => $this->title_id,
            'title'            => $this->title,
            'phone'            => $this->phone,
            'country_id'       => $this->country_id,
            'country'          => $this->country,
            'city'             => $this->city,
            'address'          => $this->address,
        ];
    }
}
