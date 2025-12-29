<?php
/**
 * Yazar Ekleme/Düzenleme Modal'ı
 */

// Kontrolcüden gelen veriler
$countries = $countries ?? [];
$titles = $titles ?? [];
$institutions = $institutions ?? [];
?>

<div class="kt-modal" data-kt-modal="true" id="add_author_modal">
    <!-- Blur backdrop -->
    <div class="kt-modal-backdrop"></div>

    <!-- Modal content -->
    <div class="kt-modal-content max-w-[800px] top-[10%] bg-white dark:bg-[#1e1e2d] opacity-100 visible"
        style="display: block;">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title" id="author_modal_title">Yazar Ekle</h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" data-kt-modal-dismiss="true">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>

        <div class="kt-modal-body px-5 py-5" style="max-height: calc(90vh - 120px); overflow-y: auto;">
            <form id="add_author_form" class="form flex flex-col gap-5" action="#" onsubmit="return false;">
                <!-- Hidden Fields -->
                <input type="hidden" name="author_id" value="" />
                <input type="hidden" name="author_order" value="" />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Yazar Adı -->
                    <div class="flex flex-col gap-1">
                        <label class="required text-sm font-medium text-foreground">Yazar Adı</label>
                        <input type="text" name="author_name" class="kt-input" placeholder="Yazar adını giriniz"
                            required />
                    </div>

                    <!-- Yazar Soyadı -->
                    <div class="flex flex-col gap-1">
                        <label class="required text-sm font-medium text-foreground">Yazar Soyadı</label>
                        <input type="text" name="author_surname" class="kt-input" placeholder="Yazar soyadını giriniz"
                            required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- E-posta -->
                    <div class="flex flex-col gap-1">
                        <label class="required text-sm font-medium text-foreground">E-posta</label>
                        <input type="email" name="author_email_modal" class="kt-input"
                            placeholder="E-posta adresini giriniz" required />
                    </div>

                    <!-- Telefon -->
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-foreground">Telefon</label>
                        <input type="text" name="author_phone" class="kt-input"
                            placeholder="Telefon numarasını giriniz" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Unvan -->
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-foreground">Unvan</label>
                        <select name="author_title" class="kt-select" data-kt-select="true"
                            data-placeholder="Unvan seçiniz">
                            <option value="">Unvan seçiniz</option>
                            <?php foreach ($titles as $id => $name): ?>
                                <option value="<?= esc($id) ?>"><?= esc($name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- ORCID -->
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-foreground">ORCID</label>
                        <input type="text" name="orcid" class="kt-input" placeholder="0000-0000-0000-0000" />
                    </div>
                </div>

                <!-- Kurum Bilgisi -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-foreground">Kurum</label>
                    <select name="author_institution" class="kt-select" data-kt-select="true"
                        data-placeholder="Kurum seçiniz">
                        <option value="">Kurum seçiniz</option>
                        <?php foreach ($institutions as $inst): ?>
                            <option value="<?= esc($inst['id'] ?? $inst) ?>"><?= esc($inst['name'] ?? $inst) ?></option>
                        <?php endforeach; ?>
                        <option value="other">Diğer (Listede Yok)</option>
                    </select>
                    <div class="flex items-center gap-2 mt-1" id="no_institution_checkbox_group">
                        <input type="checkbox" id="no_institution_checkbox" class="kt-checkbox size-4" />
                        <label for="no_institution_checkbox" class="text-xs text-muted-foreground cursor-pointer">Kurum
                            bilgisi eklemek istemiyorum</label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Ülke -->
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-foreground">Ülke</label>
                        <select name="author_country" class="kt-select" data-kt-select="true"
                            data-placeholder="Ülke seçiniz">
                            <option value="">Ülke seçiniz</option>
                            <?php foreach ($countries as $code => $country): ?>
                                <?php $cName = is_array($country) ? ($country['name'] ?? $code) : $country; ?>
                                <option value="<?= esc($code) ?>"><?= esc($cName) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Şehir -->
                    <div class="flex flex-col gap-1">
                        <label class="text-sm font-medium text-foreground">Şehir</label>
                        <input type="text" name="author_city" class="kt-input" placeholder="Şehir giriniz" />
                    </div>
                </div>

                <!-- Adres -->
                <div class="flex flex-col gap-1">
                    <label class="text-sm font-medium text-foreground">Açık Adres</label>
                    <textarea name="author_address" class="kt-input" rows="2"
                        placeholder="Tebligat adresi..."></textarea>
                </div>

                <!-- Sorumlu Yazar Kontrolü -->
                <div class="flex items-center gap-2 bg-accent/5 p-3 rounded-lg border border-border">
                    <input type="checkbox" name="author_is_corresponding" id="author_is_corresponding"
                        class="kt-checkbox size-4" />
                    <label for="author_is_corresponding"
                        class="text-sm font-medium text-foreground cursor-pointer">Sorumlu Yazar Olarak İşaretle</label>
                </div>
            </form>
        </div>

        <div class="kt-modal-footer">
            <button type="button" class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="true">İptal</button>
            <button type="button" class="kt-btn kt-btn-primary" id="kt_modal_add_author_submit" data-author-modal-submit
                onclick="handleAuthorModalSubmit()">Kaydet</button>
        </div>
    </div>
</div>

<script>
    function handleAuthorModalSubmit() {
        const mode = window.__contentStep2State?.modal?.mode;
        if (mode === 'edit') {
            if (typeof window.addContentStep2UpdateAuthor === 'function') {
                window.addContentStep2UpdateAuthor();
            } else if (typeof window.updateAuthor === 'function') {
                window.updateAuthor();
            }
        } else {
            if (typeof window.addContentStep2SaveAuthor === 'function') {
                window.addContentStep2SaveAuthor();
            }
        }
    }
</script>