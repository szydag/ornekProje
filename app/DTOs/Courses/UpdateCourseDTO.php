<?php
declare(strict_types=1);

namespace App\DTOs\Courses;

/**
 * KISMİ güncelleme destekler.
 * Boş bırakılan alanlar değişmez.
 * 
 * Yöneticiler için iki seçenek:
 *  - replaceManagers=true + managerIds[] => tam senkronizasyon (var olan set bu diziyle eşitlenir)
 *  - addManagerIds[] / removeManagerIds[] => artımlı ekle/çıkar
 */
final class UpdateCourseDTO
{
    /** @param int[]|null $managerIds
     *  @param int[]|null $addManagerIds
     *  @param int[]|null $removeManagerIds
     */
    public function __construct(
        public int $id,
        public ?string $title            = null,
        public ?string $description      = null,
        public ?string $startDate        = null,   // 'YYYY-MM-DD'
        public ?string $endDate          = null,   // 'YYYY-MM-DD' | null (null verilirse end_date'i null'la)
        public ?bool   $indefinite       = null,   // true => end_date null
        // Yöneticiler
        public ?array  $managerIds       = null,   // replaceManagers=true ise zorunlu
        public bool    $replaceManagers  = false,  // true ise managerIds ile tam eşitle
        public ?array  $addManagerIds    = null,   // artımlı ekleme
        public ?array  $removeManagerIds = null    // artımlı çıkarma
    ) {}
}


