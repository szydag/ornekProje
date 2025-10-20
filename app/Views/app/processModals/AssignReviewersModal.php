<!-- Değerlendirici Atama Modal -->
<div class="kt-modal" data-kt-modal="true" id="assignReviewersModal" style="display: none;">
  <div class="kt-modal-content max-w-[600px] overflow-visible">
    <!-- Header -->
    <div class="kt-modal-header py-4 px-5">
      <div class="flex items-center gap-3">
        <i class="ki-filled ki-user-plus text-primary text-xl"></i>
        <h3 class="text-lg font-semibold text-mono">Değerlendirici Ata</h3>
      </div>
      <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" onclick="closeAssignReviewersModal()">
        <i class="ki-filled ki-cross"></i>
      </button>
    </div>

    <!-- Body -->
    <div class="kt-modal-body p-5 overflow-visible">
      <!-- Alert Container -->
      <div class="space-y-3 mb-4" id="assignAlertContainer" style="display: none;"></div>

      <!-- Açıklama -->
      <div class="text-center mb-4">
        <p class="text-gray-600">
          Bu içerikye değerlendirici olarak atanacak kullanıcıları seçiniz.
        </p>
      </div>

      <div class="kt-form-field">
        <label class="kt-form-label mb-2">
          Değerlendiriciler <span class="text-danger">*</span>
        </label>
        <!-- Seçili değerlendiricileri göster -->
        <div id="selected_reviewers" class="mb-2 hidden">
          <div class="flex flex-wrap gap-1"></div>
        </div>

        <!-- Dropdown container -->
        <div class="relative">
          <input type="text"
            class="kt-input"
            id="reviewers_search"
            placeholder="Değerlendirici arayın veya seçin..."
            autocomplete="off"
            readonly
            onclick="toggleReviewerDropdown()">

          <!-- Dropdown -->
          <div id="reviewers_dropdown" class="hidden absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-64 overflow-auto">
            <div class="p-2 border-b border-gray-200 sticky top-0 bg-white">
              <input type="text"
                class="kt-input"
                id="reviewer_filter"
                placeholder="Değerlendirici ara..."
                autocomplete="off"
                oninput="filterReviewers()">
            </div>
            <div id="reviewersList" class="p-2">
              <!-- Değerlendiriciler buraya yüklenecek -->
            </div>
          </div>

        </div>

        <div class="kt-form-description text-2sm mt-1">
          En az bir değerlendirici seçiniz
        </div>

        <!-- Hidden input for selected reviewers -->
        <input type="hidden" name="reviewers" id="reviewers_hidden" value="">
        <div class="text-red-600 text-sm italic mt-1" id="reviewers-error" style="display: none;"></div>
      </div>
    </div>

    <!-- Footer -->
    <div class="kt-modal-footer py-4 px-5">
      <button class="kt-btn kt-btn-outline" onclick="closeAssignReviewersModal()">Vazgeç</button>
      <button class="kt-btn kt-btn-primary" type="button" onclick="submitAssignReviewers()">
        Kaydet
      </button>
    </div>
  </div>
</div>

<script>
  // Global değişkenler
  let REVIEWERS = [];
  let CURRENT_CONTENT_ID = null;

  // Modal açma fonksiyonu
  async function openAssignReviewersModal() {

    const modal = document.getElementById('assignReviewersModal');
    if (!modal) {
      console.error('assignReviewersModal elementi bulunamadı!');
      return;
    }

    // Backdrop ekle
    const backdrop = document.createElement('div');
    backdrop.className = 'kt-modal-backdrop';
    backdrop.style.cssText = `
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
    `;
    backdrop.onclick = () => closeAssignReviewersModal();
    document.body.appendChild(backdrop);

    // Modal'ı göster
    modal.style.display = 'flex';
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.zIndex = '10000';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    modal.style.overflow = 'visible';
    modal.classList.add('kt-modal-open');
    document.body.classList.add('kt-modal-open');

    // Modal content'e de overflow-visible ekle
    const modalContent = modal.querySelector('.kt-modal-content');
    if (modalContent) {
      modalContent.style.overflow = 'visible';
      modalContent.style.maxHeight = 'none';
    }

    // Değerlendiricileri yükle
    await loadReviewers();

    // Form'u temizle
    clearForm();
    clearAlerts();
  }

  // Modal kapatma fonksiyonu
  function closeAssignReviewersModal() {

    const modal = document.getElementById('assignReviewersModal');
    if (!modal) return;

    // Modal'ı gizle
    modal.style.display = 'none';
    modal.classList.remove('kt-modal-open');
    document.body.classList.remove('kt-modal-open');

    // Backdrop'ları temizle
    document.querySelectorAll('.kt-modal-backdrop').forEach(backdrop => backdrop.remove());

    // Body stillerini temizle
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';

    // Form'u temizle
    clearForm();
    clearAlerts();
  }

  // Değerlendiricileri yükleme fonksiyonu
  async function loadReviewers() {
    try {
      const response = await fetch('/api/refereeUsers?role_id=4');
      const data = await response.json();

      if (data.success && data.data?.users) {
        REVIEWERS = data.data.users.map(user => ({
          id: user.id,
          name: user.name || user.email
        }));
        renderReviewerList(REVIEWERS);
      } else {
        console.error('Değerlendirici verisi alınamadı:', data);
        showAlert('warning', 'Değerlendirici verisi yüklenemedi', 'Uyarı');
      }
    } catch (error) {
      console.error('Değerlendirici yükleme hatası:', error);
      showAlert('destructive', 'Değerlendiriciler yüklenirken hata oluştu', 'Hata');
    }
  }

  // Dropdown açma/kapama
  function toggleReviewerDropdown() {
    const dropdown = document.getElementById('reviewers_dropdown');
    if (dropdown.classList.contains('hidden')) {
      dropdown.classList.remove('hidden');
      const modalBody = document.querySelector('#assignReviewersModal .kt-modal-body');
      if (modalBody) {
        modalBody.classList.add('min-h-[340px]');
      }
      // Dış tıklama ile kapatma
      setTimeout(() => {
        document.addEventListener('click', closeDropdownOnOutsideClick);
      }, 100);
    } else {
      dropdown.classList.add('hidden');
      const modalBody = document.querySelector('#assignReviewersModal .kt-modal-body');
      if (modalBody) {
        modalBody.classList.remove('min-h-[340px]');
      }
      document.removeEventListener('click', closeDropdownOnOutsideClick);
    }
  }

  // Dış tıklama ile dropdown kapatma
  function closeDropdownOnOutsideClick(event) {
    const dropdown = document.getElementById('reviewers_dropdown');
    const searchInput = document.getElementById('reviewers_search');

    if (!dropdown.contains(event.target) && event.target !== searchInput) {
      dropdown.classList.add('hidden');
      const modalBody = document.querySelector('#assignReviewersModal .kt-modal-body');
      if (modalBody) {
        modalBody.classList.remove('min-h-[340px]');
      }
      document.removeEventListener('click', closeDropdownOnOutsideClick);
    }
  }

  // Değerlendirici listesini render etme
  function renderReviewerList(reviewers) {
    const container = document.getElementById('reviewersList');
    if (!container) return;

    container.innerHTML = '';

    if (reviewers.length === 0) {
      container.innerHTML = '<p class="text-gray-500 text-center py-4">Değerlendirici bulunamadı</p>';
      return;
    }

    reviewers.forEach(reviewer => {
      const div = document.createElement('div');
      div.className = 'flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer reviewer-item';
      div.setAttribute('data-reviewer-id', reviewer.id);
      div.setAttribute('data-reviewer-name', reviewer.name);
      div.innerHTML = `
        <span class="text-sm">${reviewer.name}</span>
      `;
      div.onclick = () => {
        selectReviewer(reviewer.id, reviewer.name);
      };
      container.appendChild(div);
    });
  }

  // Değerlendirici filtreleme
  function filterReviewers() {
    const searchTerm = document.getElementById('reviewer_filter').value.toLowerCase();
    const filtered = REVIEWERS.filter(reviewer =>
      reviewer.name.toLowerCase().includes(searchTerm)
    );
    renderReviewerList(filtered);
  }

  // Seçili değerlendiriciler dizisi
  let selectedReviewers = [];

  // Değerlendirici seçme fonksiyonu
  function selectReviewer(id, name) {
    if (selectedReviewers.find(reviewer => reviewer.id === id)) {
      removeReviewerSelection(id);
      return;
    }

    selectedReviewers.push({
      id: id,
      name: name
    });
    updateSelectedReviewers();

    // Dropdown'dan seçilen değerlendiricii gizle
    const reviewerItem = document.querySelector(`[data-reviewer-id="${id}"]`);
    if (reviewerItem) {
      reviewerItem.style.display = 'none';
    }
  }

  // Seçili değerlendiricileri güncelleme
  function updateSelectedReviewers() {
    const selectedContainer = document.getElementById('selected_reviewers');
    const selectedDiv = selectedContainer.querySelector('div');
    const searchInput = document.getElementById('reviewers_search');
    const hiddenInput = document.getElementById('reviewers_hidden');

    selectedDiv.innerHTML = '';

    if (selectedReviewers.length > 0) {
      selectedContainer.classList.remove('hidden');

      selectedReviewers.forEach(reviewer => {
        const badge = document.createElement('span');
        badge.className = 'inline-flex items-center gap-1 px-2 py-1 text-xs bg-primary/10 text-primary rounded-full';

        const label = document.createElement('span');
        label.textContent = reviewer.name;
        badge.appendChild(label);

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'ml-1 text-primary hover:text-primary-dark focus:outline-none remove-reviewer-btn';
        removeBtn.innerHTML = '&times;';
        removeBtn.dataset.reviewerId = String(reviewer.id);
        removeBtn.addEventListener('click', (event) => {
          event.preventDefault();
          event.stopPropagation();
          removeReviewerSelection(reviewer.id);
        });

        badge.appendChild(removeBtn);
        selectedDiv.appendChild(badge);
      });

      searchInput.value = `${selectedReviewers.length} değerlendirici seçildi`;
      hiddenInput.value = selectedReviewers.map(reviewer => reviewer.id).join(',');
    } else {
      selectedContainer.classList.add('hidden');
      searchInput.value = '';
      hiddenInput.value = '';
    }
  }

  // Değerlendirici seçimini kaldırma
  function removeReviewerSelection(id) {
    selectedReviewers = selectedReviewers.filter(reviewer => reviewer.id !== id);
    updateSelectedReviewers();

    // Dropdown'da değerlendiricii tekrar göster
    const reviewerItem = document.querySelector(`[data-reviewer-id="${id}"]`);
    if (reviewerItem) {
      reviewerItem.style.display = 'flex';
    }
  }

  // Form gönderme
  async function submitAssignReviewers() {
    try {

      // Seçili değerlendiricileri al
      const selectedIds = selectedReviewers.map(reviewer => reviewer.id);

      // Validasyon
      if (selectedIds.length === 0) {
        showFieldError('reviewers', 'En az bir değerlendirici seçiniz.');
        showAlert('warning', 'En az bir değerlendirici seçiniz.', 'Uyarı');
        return;
      }

      // Eğitim İçeriği ID'sini al
      const learningMaterialId = getContentId();
      if (!learningMaterialId) {
        showAlert('destructive', 'Eğitim İçeriği ID bulunamadı', 'Hata');
        return;
      }

      // API çağrısı
      const response = await fetch(`/api/materials/${learningMaterialId}/assign-reviewers`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
          reviewer_ids: selectedIds
        })
      });

      const result = await response.json();

      if (result.success) {
        showPageAlert('success', 'Değerlendiriciler başarıyla atandı', 'Başarılı');
        const meta = result.data?.meta || null;
        if (meta) {
          window.CONTENT_REVIEW_META = {
            total: Number(meta.total) || 0,
            pending: Number(meta.pending) || 0,
          };
        }
        if (typeof window.fetchUIActions === 'function') {
          try {
            await window.fetchUIActions();
          } catch (err) {
            console.warn('UI aksiyonları yenilenemedi:', err);
          }
        }
        if (typeof window.renderActionButtons === 'function') {
          window.renderActionButtons();
        }
        closeAssignReviewersModal();
      } else {
        throw new Error(result.error || 'Değerlendirici atama başarısız');
      }

    } catch (error) {
      console.error('Değerlendirici atama hatası:', error);
      showAlert('destructive', error.message || 'Değerlendirici atama sırasında hata oluştu', 'Hata');
    }
  }

  // Eğitim İçeriği ID'sini alma
  function getContentId() {
    // URL'den al
    const pathParts = window.location.pathname.split('/');
    const contentIndex = pathParts.indexOf('contents');
    if (contentIndex !== -1 && pathParts[contentIndex + 1]) {
      const parsedId = Number(pathParts[contentIndex + 1]);
      if (!Number.isNaN(parsedId) && parsedId > 0) {
        return parsedId;
      }
    }

    // Global değişkenden al
    if (typeof CONTENT_ID !== 'undefined' && Number(CONTENT_ID) > 0) {
      return Number(CONTENT_ID);
    }

    if (typeof window !== 'undefined' && typeof window.CONTENT_ID !== 'undefined') {
      const winId = Number(window.CONTENT_ID);
      if (!Number.isNaN(winId) && winId > 0) {
        return winId;
      }
    }

    return null;
  }

  // Form temizleme
  function clearForm() {
    const filterInput = document.getElementById('reviewer_filter');
    if (filterInput) filterInput.value = '';

    // Seçili değerlendiricileri temizle
    selectedReviewers = [];
    updateSelectedReviewers();

    // Dropdown'daki tüm değerlendiricileri tekrar göster
    const reviewerItems = document.querySelectorAll('.reviewer-item');
    reviewerItems.forEach(item => {
      item.style.display = 'flex';
    });

    const dropdown = document.getElementById('reviewers_dropdown');
    if (dropdown) dropdown.classList.add('hidden');
  }

  // Alert fonksiyonları
  function showAlert(type, message, title = null) {
    const container = document.getElementById('assignAlertContainer');
    if (!container) return;

    const alertId = 'alert_' + Date.now();
    const alertClass = `kt-alert-${type}`;
    const alertTitle = title || getDefaultTitle(type);

    const alertHTML = `
      <div class="kt-alert kt-alert-light ${alertClass}" id="${alertId}">
        <div class="kt-alert-icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 16v-4"></path>
            <path d="M12 8h.01"></path>
          </svg>
        </div>
        <div class="kt-alert-title">${alertTitle}</div>
        <div class="kt-alert-toolbar">
          <div class="kt-alert-actions">
            <button class="kt-alert-close" onclick="document.getElementById('${alertId}').remove()">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
              </svg>
            </button>
          </div>
        </div>
      </div>
    `;

    container.insertAdjacentHTML('beforeend', alertHTML);
    container.style.display = 'block';

    // 5 saniye sonra otomatik kapat
    setTimeout(() => {
      const alert = document.getElementById(alertId);
      if (alert) {
        alert.remove();
        if (container.children.length === 0) {
          container.style.display = 'none';
        }
      }
    }, 5000);
  }

  function getDefaultTitle(type) {
    const titles = {
      success: 'Başarılı!',
      primary: 'Bilgi',
      info: 'Bilgi',
      warning: 'Uyarı',
      destructive: 'Hata'
    };
    return titles[type] || 'Bilgi';
  }

  function clearAlerts() {
    const container = document.getElementById('assignAlertContainer');
    if (container) {
      container.innerHTML = '';
      container.style.display = 'none';
    }
  }

  // Field error fonksiyonları
  function showFieldError(fieldId, message) {
    const errorDiv = document.getElementById(fieldId + '-error');
    if (errorDiv) {
      errorDiv.textContent = message;
      errorDiv.style.display = 'block';
    }
  }

  function clearFieldError(fieldId) {
    const errorDiv = document.getElementById(fieldId + '-error');
    if (errorDiv) {
      errorDiv.style.display = 'none';
    }
  }

  // Page alert fonksiyonu (content-detail.php'deki ile uyumlu)
  function showPageAlert(type, message, title = null) {
    if (typeof window.showPageAlert === 'function' && window.showPageAlert !== showPageAlert) {
      window.showPageAlert(type, message, title);
    }
  }

  // Event listener'lar
  document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        const modal = document.getElementById('assignReviewersModal');
        if (modal && modal.style.display !== 'none') {
          closeAssignReviewersModal();
        }
      }
    });
  });

  // Global fonksiyon olarak tanımla
  window.openAssignReviewersModal = openAssignReviewersModal;
  window.closeAssignReviewersModal = closeAssignReviewersModal;
</script>
