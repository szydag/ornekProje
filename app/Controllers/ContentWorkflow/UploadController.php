<?php
declare(strict_types=1);

namespace App\Controllers\ContentWorkflow;

use App\Controllers\BaseController;

final class UploadController extends BaseController
{
    public function store()
    {
        $file = $this->request->getFile('file');
        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => $file?->getErrorString() ?? 'Dosya alınamadı']);
        }

        if ($file->hasMoved()) {
            return $this->response->setStatusCode(400)
                ->setJSON(['success' => false, 'error' => 'Dosya zaten taşındı.']);
        }

        $targetDir = WRITEPATH . 'process';
        if (!is_dir($targetDir) && !mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            return $this->response->setStatusCode(500)
                ->setJSON(['success' => false, 'error' => 'Klasör oluşturulamadı.']);
        }

        $randomName   = $file->getRandomName(); // uzantıyı korur
        $file->move($targetDir, $randomName);

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'stored_name' => $randomName,
                'original_name' => $file->getClientName(),
                'path' => 'process/' . $randomName,
                'size' => $file->getSize(),
                'mime' => $file->getClientMimeType(),
            ],
        ]);
    }
}
