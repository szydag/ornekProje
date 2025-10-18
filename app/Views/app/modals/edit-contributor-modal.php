<div class="kt-modal" data-kt-modal="true" id="edit_author_modal">
    <!-- Blur backdrop -->
    <div class="kt-modal-backdrop"></div>

    <!-- Modal content -->
    <div class="kt-modal-content" style="max-height: 90vh;">
        <div class="kt-modal-header pr-2.5">
            <h3 class="kt-modal-title">
                Katkıda Bulunan Güncelle
            </h3>
            <button class="kt-btn kt-btn-icon kt-btn-ghost shrink-0" onclick="closeEditAuthorModal()">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body px-5 py-5" style="max-height: calc(80vh - 120px); overflow-y: auto; overflow-x: hidden; visibility: visible; opacity: 1; background: white;">
            <div class="grid gap-5">
                <!-- Ad ve Soyad -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Adı <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="edit_author_name" type="text" placeholder="Katkıda Bulunan adı" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Soyadı <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="edit_author_surname" type="text" placeholder="Katkıda Bulunan soyadı" />
                    </div>
                </div>

                <!-- Ünvan ve Kurum -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Ünvan
                        </label>
                        <select class="kt-input" name="edit_author_title" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <?php foreach ($academicTitles as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Kurum <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" name="edit_author_institution" data-search="true" data-responsible-field="institution" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <?php foreach ($universities as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- E-posta ve Telefon -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            E-Posta <span class="text-danger">*</span>
                        </label>
                        <input class="kt-input" name="edit_author_email" type="email" placeholder="aysegulbicil63@gmail.com" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Telefon
                        </label>
                        <input class="kt-input" name="edit_author_phone" type="tel" placeholder="05435780800" data-responsible-field="phone" />
                    </div>
                </div>

                <!-- ORCID -->
                <div class="flex flex-col gap-1">
                    <label class="kt-label text-sm font-medium text-foreground">
                        ORCID (16 haneli)
                    </label>
                    <input class="kt-input" name="edit_author_orcid" type="text" placeholder="X" data-responsible-field="orcid" />
                    <div class="kt-form-description text-2sm">
                        Örneğin: XXXX-XXXX-XXXX-XXXX
                    </div>
                </div>

                <!-- Ülke ve Şehir -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" style="z-index: 2 !important;">
                    <div class="flex flex-col gap-1" style="z-index: 2 !important;">
                        <label class="kt-label text-sm font-medium text-foreground" style="z-index: 2 !important;">
                            Ülke <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" name="edit_author_country" id="edit_author_country" onchange="loadCities('edit_author_country', 'edit_author_city')" style="z-index: 2 !important;" data-responsible-field="country" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <option value="">Ülke seçingbggiz...</option>
                            <option value="tr">Türkiye</option>
                            <option value="us">Amerika Birleşik Devletleri</option>
                            <option value="gb">Birleşik Krallık</option>
                            <option value="de">Almanya</option>
                            <option value="fr">Fransa</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-label text-sm font-medium text-foreground">
                            Şehir <span class="text-danger">*</span>
                        </label>
                        <select class="kt-select" data-kt-select="true" name="edit_author_city" id="edit_author_city" disabled data-responsible-field="city" data-kt-select-config='{
                            "optionsClass": "kt-scrollable overflow-auto max-h-[250px]"
                        }'>
                            <option value="">Önce ülke seçiniz...</option>
                        </select>
                    </div>
                </div>

                <!-- Adres -->
                <div class="flex flex-col gap-1" style="z-index: 1 !important;">
                    <label class="kt-label text-sm font-medium text-foreground">
                        Adres
                    </label>
                    <textarea class="kt-textarea" name="edit_author_address" rows="3" placeholder="Katkıda Bulunan adresi"></textarea>
                </div>
            </div>
        </div>
        <div class="kt-modal-footer">
            <button type="button" class="kt-btn kt-btn-outline" onclick="closeEditAuthorModal()">
                İptal
            </button>
            <button type="button" class="kt-btn kt-btn-primary" onclick="updateAuthor()">
                Güncelle
            </button>
        </div>
    </div>
</div>
