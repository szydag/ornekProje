<?php // app/Views/app/processModals/ActionModal.php 
?>
<div class="kt-modal" data-kt-modal="true" id="actionModal">
  <div class="kt-modal-content max-w-[600px] top-[15%]">
    <div class="kt-modal-header py-4 px-5">
      <div class="flex items-center gap-3">
        <i class="ki-filled ki-edit-square text-primary text-xl"></i>
        <h3 class="text-lg font-semibold text-mono" id="actionModalTitle">İşlem</h3>
      </div>
      <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" data-kt-modal-dismiss="true">
        <i class="ki-filled ki-cross"></i>
      </button>
    </div>
    <div class="kt-modal-body p-5" style="max-height: 70vh; overflow-y: auto;">
      <div class="space-y-3 mb-4" id="actionAlertContainer" style="display: none;"></div>
      <form id="actionForm" class="space-y-5">
        <div class="kt-form-field">
          <label class="kt-form-label mb-2" for="actionNote" id="actionNoteLabel">
            Açıklama <span class="text-danger" id="actionNoteRequired">*</span>
          </label>
          <textarea id="actionNote" name="note" class="kt-textarea w-full" rows="4" placeholder="Kısa bir not bırakın..." required></textarea>
          <div class="text-sm italic font-bold mt-1" id="actionNote-error" style="display: none; color: #dc2626;"></div>
        </div>
        <div class="kt-form-field">
          <label class="kt-form-label mb-2" for="actionFile">
            Dosya <span class="text-muted-foreground text-xs font-normal">(opsiyonel)</span>
          </label>
          <input
            id="actionFile"
            name="file"
            type="file"
            class="kt-input"
            accept=".pdf,.doc,.docx,.txt,.png,.jpg,.jpeg" />
          <p class="text-xs text-secondary-foreground mt-1">
            PDF, Word, metin dosyası veya resim yükleyebilirsiniz
          </p>
        </div>
      </form>
    </div>
    <div class="kt-modal-footer py-4 px-5">
      <button class="kt-btn kt-btn-outline" data-kt-modal-dismiss="true">Vazgeç</button>
      <button class="kt-btn kt-btn-primary" type="button" data-action-submit onclick="submitAction()">
        Gönder
      </button>
    </div>
  </div>
</div>

<script>
  (function() {
    const MODAL_ID = 'actionModal';
    const FORM_ID = 'actionForm';
    const NOTE_FIELD_ID = 'actionNote';
    const FILE_FIELD_ID = 'actionFile';
    const ALERT_CONTAINER_ID = 'actionAlertContainer';
    const SUBMIT_SELECTOR = '[data-action-submit]';

    const defaultAlertTitles = {
      success: 'Başarılı!',
      primary: 'Bilgi',
      info: 'Bilgi',
      warning: 'Uyarı',
      destructive: 'Hata'
    };

    let currentActionCode = null;

    function getModal() {
      return document.getElementById(MODAL_ID);
    }

    function getForm() {
      return document.getElementById(FORM_ID);
    }

    function getAlertContainer() {
      return document.getElementById(ALERT_CONTAINER_ID);
    }

    function showAlert(type, message, title = null) {
      const container = getAlertContainer();
      if (!container) {
        return;
      }

      const alertId = `alert_${Date.now()}`;
      const alertTitle = title || defaultAlertTitles[type] || 'Bilgi';

      const alertHtml = `
                <div class="kt-alert kt-alert-light kt-alert-${type}" id="${alertId}">
                    <div class="kt-alert-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 16v-4"></path>
                            <path d="M12 8h.01"></path>
                        </svg>
                    </div>
                    <div class="kt-alert-title">${alertTitle}</div>
                    <div class="kt-alert-toolbar ml-auto" style="margin-left: auto;">
                        <div class="kt-alert-actions">
                            <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                                    <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    ${message ? `<div class="kt-alert-text text-sm mt-2" style="flex-basis: 100%;">${message}</div>` : ''}
                </div>
            `;

      container.insertAdjacentHTML('beforeend', alertHtml);
      container.style.display = 'block';

      setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
          alert.remove();
          if (!container.children.length) {
            container.style.display = 'none';
          }
        }
      }, 5000);
    }

    function clearAlerts() {
      const container = getAlertContainer();
      if (!container) {
        return;
      }

      container.innerHTML = '';
      container.style.display = 'none';
    }

    function setButtonLoading(isLoading) {
      const button = document.querySelector(SUBMIT_SELECTOR);
      if (!button) {
        return;
      }

      button.disabled = isLoading;
      button.classList.toggle('pointer-events-none', isLoading);
      button.classList.toggle('opacity-70', isLoading);
    }

    function showFieldError(fieldId, message) {
      const errorElement = document.getElementById(`${fieldId}-error`);
      if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.display = 'block';
      }

      const field = document.getElementById(fieldId);
      if (field) {
        field.classList.add('border-red-500');
        field.focus();
      }
    }

    function clearFieldError(fieldId) {
      const errorElement = document.getElementById(`${fieldId}-error`);
      if (errorElement) {
        errorElement.style.display = 'none';
      }

      const field = document.getElementById(fieldId);
      if (field) {
        field.classList.remove('border-red-500');
      }
    }

    function clearErrors() {
      clearFieldError(NOTE_FIELD_ID);
    }

    function resetForm() {
      const form = getForm();
      if (form) {
        form.reset();
      }
    }

    function clearBackdrops() {
      document.querySelectorAll('.kt-modal-backdrop, [data-kt-modal-backdrop]').forEach((backdrop) => backdrop.remove());
    }

    function restoreBodyStyles() {
      document.body.style.filter = '';
      document.body.style.backdropFilter = '';
      document.body.style.overflow = '';
      document.body.style.paddingRight = '';
    }

    function closeModal() {
      const modal = getModal();
      if (!modal) {
        return;
      }

      modal.style.display = 'none';
      modal.classList.remove('kt-modal-open');
      document.body.classList.remove('kt-modal-open');

      clearBackdrops();
      restoreBodyStyles();
      resetForm();
      clearAlerts();
      clearErrors();
      setButtonLoading(false);
    }

    function openModal(actionCode) {
      currentActionCode = actionCode;

      const modal = getModal();
      if (!modal) {
        return;
      }

      modal.style.display = 'flex';
      modal.classList.add('kt-modal-open');
      document.body.classList.add('kt-modal-open');

      const titleElement = document.getElementById('actionModalTitle');
      if (titleElement) {
        titleElement.textContent = typeof labelFor === 'function' ? labelFor(actionCode) : 'İşlem';
      }

      // Onay işlemi için açıklama alanını opsiyonel yap
      const noteField = document.getElementById(NOTE_FIELD_ID);
      const requiredSpan = document.getElementById('actionNoteRequired');
      
      if (actionCode === 'onay') {
        if (noteField) {
          noteField.removeAttribute('required');
        }
        if (requiredSpan) {
          requiredSpan.style.display = 'none';
        }
      } else {
        if (noteField) {
          noteField.setAttribute('required', 'required');
        }
        if (requiredSpan) {
          requiredSpan.style.display = 'inline';
        }
      }

      resetForm();
      clearAlerts();
      clearErrors();
    }

    async function uploadAttachment(fileInput) {
      if (!fileInput || !fileInput.files || !fileInput.files[0]) {
        return null;
      }

      const formData = new FormData();
      formData.append('file', fileInput.files[0]);

      const response = await fetch('/api/uploads', {
        method: 'POST',
        body: formData
      });

      const json = await response.json();
      if (!json.success) {
        throw new Error(json.error || 'Dosya yüklenemedi');
      }

      return json.data.id;
    }

    async function submitAction() {
      try {
        clearAlerts();
        clearErrors();

        const form = getForm();
        if (!form) {
          return;
        }

        const noteField = document.getElementById(NOTE_FIELD_ID);
        const note = noteField ? noteField.value.trim() : '';
        const fileInput = document.getElementById(FILE_FIELD_ID);

        // Açıklama zorunluluğu kontrolü (onay işlemi hariç)
        if (!note && currentActionCode !== 'onay') {
          showFieldError(NOTE_FIELD_ID, 'Açıklama alanı zorunludur.');
          return;
        }

        setButtonLoading(true);

        const attachmentId = await uploadAttachment(fileInput);

        const payload = {
          action_code: currentActionCode
        };

        if (note) {
          payload.note = note;
        }

        if (attachmentId) {
          payload.attachment_id = attachmentId;
        }

        const response = await fetch(`/api/materials/${CONTENT_ID}/action`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          },
          body: JSON.stringify(payload)
        });

        const json = await response.json();
        if (!response.ok || !json.success) {
          throw new Error(json.error || 'İşlem başarısız');
        }

        // Modal'ı kapat
        resetForm();
        closeModal();

        // Sayfa alert'ini göster
        showPageAlert('success', 'İşlem başarılı', typeof labelFor === 'function' ? labelFor(currentActionCode) : 'İşlem');

        // Butonları güncelle - daha güvenilir yöntem
        setTimeout(async () => {
          try {
            // Önce state'i yeniden fetch et
            if (typeof fetchUIActions === 'function') {
              await fetchUIActions();
            }
            
            // Sonra butonları render et
            if (typeof renderActionButtons === 'function') {
              renderActionButtons();
            }
            
            // Sayfa yenilenmesi için event dispatch et
            window.dispatchEvent(new CustomEvent('articleStateChanged', {
              detail: { actionCode: currentActionCode, success: true }
            }));
            
          } catch (error) {
            console.error('Butonlar güncellenirken hata:', error);
            // Hata durumunda sayfayı yenile
            window.location.reload();
          }
        }, 500);
      } catch (error) {
        console.error(error);
        showAlert('destructive', error.message || 'Hata oluştu', 'İşlem Başarısız');
      } finally {
        setButtonLoading(false);
      }
    }

    function showPageAlert(type, message, title = null) {
      // Sayfanın sağ üst köşesinde alert container'ı oluştur
      let pageAlertContainer = document.getElementById('pageAlertContainer');
      if (!pageAlertContainer) {
        pageAlertContainer = document.createElement('div');
        pageAlertContainer.id = 'pageAlertContainer';
        pageAlertContainer.style.cssText = `
          position: fixed;
          top: 20px;
          right: 20px;
          z-index: 10000;
          max-width: 400px;
          width: 100%;
        `;
        document.body.appendChild(pageAlertContainer);
      }

      const alertId = 'pageAlert_' + Date.now();
      const alertClass = `kt-alert-${type}`;
      const alertTitle = title || defaultAlertTitles[type] || 'Bilgi';

      const alertHTML = `
        <div class="kt-alert kt-alert-light ${alertClass} mb-3" id="${alertId}" style="box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
          <div class="kt-alert-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info" aria-hidden="true">
              <circle cx="12" cy="12" r="10"></circle>
              <path d="M12 16v-4"></path>
              <path d="M12 8h.01"></path>
            </svg>
          </div>
          <div class="kt-alert-title">${alertTitle}</div>
          <div class="kt-alert-text text-sm mt-2">${message}</div>
          <div class="kt-alert-toolbar">
            <div class="kt-alert-actions">
              <button class="kt-alert-close" data-kt-dismiss="#${alertId}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
      `;

      pageAlertContainer.insertAdjacentHTML('beforeend', alertHTML);

      // Auto-hide after 5 seconds
      setTimeout(() => {
        const alert = document.getElementById(alertId);
        if (alert) {
          alert.style.opacity = '0';
          alert.style.transition = 'opacity 0.3s ease';
          setTimeout(() => {
            if (alert && alert.parentNode) {
              alert.remove();
            }
          }, 300);
        }
      }, 5000);

      // Close button functionality
      const closeBtn = document.querySelector(`#${alertId} .kt-alert-close`);
      if (closeBtn) {
        closeBtn.addEventListener('click', () => {
          const alert = document.getElementById(alertId);
          if (alert) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
              if (alert && alert.parentNode) {
                alert.remove();
              }
            }, 300);
          }
        });
      }
    }

    window.openActionModal = openModal;
    window.closeActionModal = closeModal;
    window.submitAction = submitAction;

    document.addEventListener('DOMContentLoaded', () => {
      const modal = getModal();

      if (!modal) {
        console.error('actionModal elementi bulunamadı!');
        return;
      }

      document.addEventListener('click', (event) => {
        const toggle = event.target.closest ? event.target.closest('[data-kt-modal-toggle="#actionModal"]') : null;
        if (toggle) {
          setTimeout(() => {
            clearAlerts();
            clearErrors();
          }, 300);
          return;
        }

        if (event.target === modal) {
          closeModal();
        }
      });

      document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('kt-modal-open')) {
          closeModal();
        }
      });

      const noteField = document.getElementById(NOTE_FIELD_ID);
      if (noteField) {
        noteField.addEventListener('input', () => {
          if (noteField.value.trim()) {
            clearFieldError(NOTE_FIELD_ID);
          }
        });
      }
    });
  })();
</script>