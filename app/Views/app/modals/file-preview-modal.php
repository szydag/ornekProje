<!-- Dosya Ön İzleme Modalı -->
<div class="kt-modal" data-kt-modal="true" id="filePreviewModal" style="display: none;">
    <!-- Modal content -->
    <div class="kt-modal-content" style="width: 98vw; max-width: 1800px; min-width: 1000px; max-height: 98vh; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10000; background: white; border-radius: 8px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
        <div class="kt-modal-header py-4 px-5">
            <h3 class="kt-modal-title" id="previewModalTitle">Dosya Ön İzleme</h3>
            <button class="kt-btn kt-btn-sm kt-btn-icon kt-btn-dim shrink-0" onclick="closeFilePreviewModal()">
                <i class="ki-filled ki-cross"></i>
            </button>
        </div>
        <div class="kt-modal-body p-0 flex-1 overflow-hidden">
            <div id="previewContent" class="min-h-[85vh] bg-gray-50">
                <!-- Loading state -->
                <div id="loadingState" class="flex items-center justify-center h-[400px]">
                    <div class="text-center">
                        <div class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                            <i class="ki-filled ki-document text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-mono mb-2">Dosya Yükleniyor...</h3>
                        <p class="text-sm text-secondary-foreground">
                            Dosya önizlemesi hazırlanıyor, lütfen bekleyin.
                        </p>
                    </div>
                </div>

                <!-- PDF Preview -->
                <div id="pdfPreview" class="hidden w-full h-full">
                    <iframe id="pdfFrame" class="w-full h-full" style="min-height: 100vh; height: 100%;" frameborder="0"></iframe>
                </div>

                <!-- Image Preview -->
                <div id="imagePreview" class="hidden w-full h-full flex items-center justify-center px-6 py-6">
                    <div class="max-w-full max-h-full overflow-hidden">
                        <img id="imageFrame" class="max-w-full max-h-full object-contain" alt="Ön İzleme" style="width: auto; height: auto; max-width: 80vw; max-height: 80vh;">
                    </div>
                </div>

                <!-- Text Preview -->
                <div id="textPreview" class="hidden w-full h-full p-6 overflow-auto">
                    <div id="textContent" class="prose prose-sm max-w-none"></div>
                </div>

                <!-- Unsupported Preview -->
                <div id="unsupportedPreview" class="hidden w-full h-full flex items-center justify-center">
                    <div class="text-center">
                        <div class="flex items-center justify-center size-16 rounded-full bg-primary/10 mb-4 mx-auto">
                            <i class="ki-filled ki-document text-2xl text-primary"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-mono mb-2">Ön İzleme Mevcut Değil</h3>
                        <p class="text-sm text-secondary-foreground mb-4">
                            Bu dosya türü için ön izleme desteklenmiyor.
                        </p>
                        <button onclick="downloadPreviewFile()" class="kt-btn kt-btn-primary">
                            <i class="ki-filled ki-download text-sm"></i>
                            Dosyayı İndir
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="kt-modal-footer py-4 px-5 border-t border-border">
            <div class="flex justify-between items-center w-full">
                <div class="text-sm text-secondary-foreground">
                    <span id="previewFileInfo"></span>
                </div>
                <div class="flex gap-2">
                    <button onclick="downloadPreviewFile()" class="kt-btn kt-btn-outline">
                        <i class="ki-filled ki-download text-sm"></i>
                        İndir
                    </button>
                    <button onclick="closeFilePreviewModal()" class="kt-btn kt-btn-primary">
                        Kapat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Dosya ön izleme fonksiyonları

window.currentPreviewFile = null;

window.setButtonLoading = function(button, isLoading) {
    if (!button) return;
    if (isLoading) {
        if (!button.dataset.loadingOriginal) {
            button.dataset.loadingOriginal = button.innerHTML;
        }
        button.disabled = true;
        button.innerHTML = '<span class="kt-spinner kt-spinner-sm kt-spinner-primary"></span>';
    } else {
        if (button.dataset.loadingOriginal) {
            button.innerHTML = button.dataset.loadingOriginal;
            delete button.dataset.loadingOriginal;
        }
        button.disabled = false;
    }
};

window.preparePreviewContainers = function() {
    window.hideAllPreviews();
    const loading = document.getElementById('loadingState');
    if (loading) {
        loading.classList.remove('hidden');
    }
};

window.previewFile = function(
    triggerEl,
    fileId,
    fileName,
    fileTypeLabel,
    fileMime = '',
    fileExtension = '',
    fileSizeLabel = '',
    downloadUrl = '',
    previewUrl = ''
) {
    const button = triggerEl instanceof HTMLElement ? triggerEl : null;
    window.setButtonLoading(button, true);

    const normalizedId = Number(fileId);
    const origin = window.location.origin;

    const meta = {
        id: normalizedId,
        name: fileName,
        label: fileTypeLabel,
        mime: fileMime,
        extension: fileExtension,
        size: fileSizeLabel,
        downloadUrl: downloadUrl || `${origin}/download/${normalizedId}`,
        previewUrl: previewUrl || `${origin}/preview/${normalizedId}`,
    };

    window.currentPreviewFile = meta;
    window.preparePreviewContainers();

    window.loadPreviewContent(meta)
        .then((result) => window.openFilePreviewModal(meta, result))
        .catch((error) => {
            console.error('previewFile error', error);
            window.currentPreviewFile = null;
            if (typeof showPageAlert === 'function') {
                showPageAlert('destructive', 'Dosya ön izleme yüklenemedi.', 'Ön İzleme Hatası');
            } else {
                alert('Dosya ön izleme yüklenemedi.');
            }
        })
        .finally(() => {
            window.setButtonLoading(button, false);
        });
};

window.loadPreviewContent = function(meta) {
    const mime = (meta.mime || '').toLowerCase();
    const extension = (meta.extension || '').toLowerCase();
    const label = (meta.label || '').toLowerCase();
    const previewUrl = meta.previewUrl;

    const isPdf = mime.includes('pdf') || extension === 'pdf' || label.includes('pdf');
    const isImage = mime.startsWith('image/') || ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(extension);
    const isText = mime.startsWith('text/') || extension === 'txt';

    if (isPdf) {
        return new Promise((resolve, reject) => {
            const iframe = document.getElementById('pdfFrame');
            if (!iframe) {
                reject(new Error('PDF ön izleme bileşeni bulunamadı.'));
                return;
            }

            iframe.onload = () => {
                iframe.onload = null;
                iframe.onerror = null;
                resolve({ type: 'pdf' });
            };
            iframe.onerror = () => {
                iframe.onload = null;
                iframe.onerror = null;
                reject(new Error('PDF yüklenirken hata oluştu.'));
            };

            iframe.src = `${previewUrl}#zoom=67`;
        });
    }

    if (isImage) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve({ type: 'image', src: previewUrl });
            img.onerror = () => reject(new Error('Görsel yüklenemedi.'));
            img.src = previewUrl;
        });
    }


    if (isText) {
        return fetch(previewUrl, { headers: { Accept: 'text/plain' } })
            .then((resp) => {
                if (!resp.ok) {
                    throw new Error('Metin dosyası okunamadı');
                }
                return resp.text();
            })
            .then((text) => ({ type: 'text', text }));
    }

    return Promise.resolve({ type: 'unsupported' });
};

window.openFilePreviewModal = function(meta, result) {
    const modal = document.getElementById('filePreviewModal');
    if (!modal) {
        return;
    }

    const titleElement = document.getElementById('previewModalTitle');
    const infoElement = document.getElementById('previewFileInfo');

    if (titleElement) {
        titleElement.textContent = meta.name;
    }

    if (infoElement) {
        const summaryParts = [];
        if (meta.label) summaryParts.push(meta.label);
        if (meta.size) summaryParts.push(meta.size);
        summaryParts.push(meta.name);
        infoElement.textContent = summaryParts.join(' • ');
    }

    modal.style.display = 'flex';
    modal.style.alignItems = 'center';
    modal.style.justifyContent = 'center';
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modal.style.zIndex = '9999';
    document.body.style.overflow = 'hidden';

    window.hideAllPreviews(true);
    const loading = document.getElementById('loadingState');
    if (loading) {
        loading.classList.add('hidden');
    }

    switch (result.type) {
        case 'pdf':
            document.getElementById('pdfPreview').classList.remove('hidden');
            break;
        case 'image':
            const imageFrame = document.getElementById('imageFrame');
            if (imageFrame) {
                imageFrame.src = result.src;
            }
            document.getElementById('imagePreview').classList.remove('hidden');
            break;
        case 'docx':
            const docxContent = document.getElementById('textContent');
            const docxPreview = document.getElementById('textPreview');
            if (docxContent) {
                docxContent.innerHTML = result.html || '<p>Bu DOCX dosyası için ön izleme oluşturulamadı.</p>';
            }
            if (docxPreview) {
                docxPreview.classList.remove('hidden');
            }
            break;
        case 'text':
            const textContent = document.getElementById('textContent');
            const textPreview = document.getElementById('textPreview');
            if (textContent) {
                textContent.textContent = result.text;
            }
            if (textPreview) {
                textPreview.classList.remove('hidden');
            }
            break;
        default:
            document.getElementById('unsupportedPreview').classList.remove('hidden');
            break;
    }
};

window.hideAllPreviews = function(preserveSources = false) {
    const loading = document.getElementById('loadingState');
    const pdfPreview = document.getElementById('pdfPreview');
    const imagePreview = document.getElementById('imagePreview');
    const textPreview = document.getElementById('textPreview');
    const unsupportedPreview = document.getElementById('unsupportedPreview');

    if (loading) loading.classList.add('hidden');
    if (pdfPreview) pdfPreview.classList.add('hidden');
    if (imagePreview) imagePreview.classList.add('hidden');
    if (textPreview) textPreview.classList.add('hidden');
    if (unsupportedPreview) unsupportedPreview.classList.add('hidden');

    if (!preserveSources) {
        const pdfFrame = document.getElementById('pdfFrame');
        if (pdfFrame) pdfFrame.src = '';
        const imageFrame = document.getElementById('imageFrame');
        if (imageFrame) imageFrame.src = '';
        const textContent = document.getElementById('textContent');
        if (textContent) textContent.innerHTML = '';
    }
}
window.closeFilePreviewModal = function() {
    const modal = document.getElementById('filePreviewModal');
    if (modal) {
        // Modal'ı gizle
        modal.style.display = 'none';
        
        // Body scroll'u geri getir
        document.body.style.overflow = '';
    }
    window.currentPreviewFile = null;

    // Tüm preview'ları temizle
    window.hideAllPreviews();

    // iframe ve img src'lerini temizle
    const pdfFrame = document.getElementById('pdfFrame');
    const imageFrame = document.getElementById('imageFrame');
    const textContent = document.getElementById('textContent');

    if (pdfFrame) pdfFrame.src = '';
    if (imageFrame) imageFrame.src = '';
    if (textContent) textContent.innerHTML = '';
}

window.downloadPreviewFile = function() {
    if (window.currentPreviewFile) {
        const targetUrl = window.currentPreviewFile.downloadUrl
            || `${window.location.origin}/download/${window.currentPreviewFile.id}`;
        window.open(targetUrl, '_blank');
    }
}

// Modal dışına tıklayınca kapatma
document.addEventListener('click', function(e) {
    const modal = document.getElementById('filePreviewModal');
    if (e.target === modal) {
        window.closeFilePreviewModal();
    }
});

// ESC tuşu ile modal kapatma
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('filePreviewModal');
        if (modal && modal.style.display === 'flex') {
            window.closeFilePreviewModal();
        }
    }
});
</script>
