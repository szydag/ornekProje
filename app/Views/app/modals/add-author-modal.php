<?php
/**
 * Yazar Ekleme Modal'ı
 */
?>
<div class="modal fade" id="add_author_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Yazar Ekle</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="add_author_form" class="form" action="#">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_author_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_author_header" data-kt-scroll-wrappers="#kt_modal_add_author_scroll" data-kt-scroll-offset="300px">
                        
                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Yazar Adı</label>
                            <input type="text" name="author_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Yazar adını giriniz" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Yazar Soyadı</label>
                            <input type="text" name="author_surname" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Yazar soyadını giriniz" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">E-posta</label>
                            <input type="email" name="author_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="E-posta adresini giriniz" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Kurum</label>
                            <input type="text" name="author_institution" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Kurum adını giriniz" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Ülke</label>
                            <select name="author_country" class="form-select form-select-solid" data-control="select2" data-placeholder="Ülke seçiniz">
                                <option value="">Ülke seçiniz</option>
                                <!-- Ülke listesi buraya eklenecek -->
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Unvan</label>
                            <select name="author_title" class="form-select form-select-solid" data-control="select2" data-placeholder="Unvan seçiniz">
                                <option value="">Unvan seçiniz</option>
                                <!-- Unvan listesi buraya eklenecek -->
                            </select>
                        </div>

                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary" id="kt_modal_add_author_submit">
                            <span class="indicator-label">Kaydet</span>
                            <span class="indicator-progress">Lütfen bekleyin...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('add_author_form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = document.getElementById('kt_modal_add_author_submit');
            const indicator = submitButton.querySelector('.indicator-label');
            const progress = submitButton.querySelector('.indicator-progress');
            
            // Loading state
            submitButton.disabled = true;
            indicator.style.display = 'none';
            progress.style.display = 'inline-block';
            
            // Simulate form submission
            setTimeout(() => {
                // Reset form
                form.reset();
                
                // Hide modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('add_author_modal'));
                if (modal) {
                    modal.hide();
                }
                
                // Reset button state
                submitButton.disabled = false;
                indicator.style.display = 'inline-block';
                progress.style.display = 'none';
                
                // Show success message
                alert('Yazar başarıyla eklendi!');
            }, 2000);
        });
    }
});
</script>


