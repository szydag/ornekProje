<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Articles\ArticleFilesModel;
use InvalidArgumentException;

class FileController extends Controller
{
    public function __construct(
        private readonly ArticleFilesModel $files = new ArticleFilesModel()
    ) {
    }

    public function preview($fileId)
    {
        try {
            $file = $this->resolveFile((int) $fileId);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(404)->setBody('Dosya bulunamadı');
        }


        $this->response->setHeader('Content-Type', $file['mime']);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $file['name'] . '"');
        $this->response->setHeader('Cache-Control', 'public, max-age=3600');
        if (!empty($file['size'])) {
            $this->response->setHeader('Content-Length', (string) $file['size']);
        }

        $content = file_get_contents($file['absolute_path']);
        return $this->response->setBody($content ?: '');
    }

    public function download($fileId)
    {
        try {
            $file = $this->resolveFile((int) $fileId);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(404)->setBody('Dosya bulunamadı');
        }

        $this->response->setHeader('Content-Type', $file['mime']);
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $file['name'] . '"');
        $this->response->setHeader('Cache-Control', 'public, max-age=3600');
        if (!empty($file['size'])) {
            $this->response->setHeader('Content-Length', (string) $file['size']);
        }

        $content = file_get_contents($file['absolute_path']);
        return $this->response->setBody($content ?: '');
    }

    /**
     * @return array{
     *     id:int,
     *     content_id:int,
     *     name:string,
     *     mime:string,
     *     extension:string,
     *     absolute_path:string
     * }
     */
    private function resolveFile(int $fileId): array
    {
        if ($fileId <= 0) {
            throw new InvalidArgumentException('Geçersiz dosya kimliği');
        }

        $row = $this->files->find($fileId);
        if (!$row) {
            throw new InvalidArgumentException('Dosya kaydı bulunamadı');
        }

        $displayName = $row['name'] ?? ('Dosya-' . $fileId);
        $contentId = (int) ($row['content_id'] ?? 0);
        $extension = strtolower((string) pathinfo($displayName, PATHINFO_EXTENSION));

        $baseDir = rtrim(WRITEPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'contents' . DIRECTORY_SEPARATOR . $contentId . DIRECTORY_SEPARATOR;

        if (!is_dir($baseDir)) {
            throw new InvalidArgumentException('Dosya fiziksel olarak bulunamadı');
        }

        $absolute = null;
        if ($displayName && is_file($baseDir . $displayName)) {
            $absolute = $baseDir . $displayName;
        } else {
            $candidates = glob($baseDir . $displayName);
            if (empty($candidates)) {
                $filenameOnly = (string) pathinfo($displayName, PATHINFO_FILENAME);
                if ($filenameOnly !== '') {
                    $candidates = glob($baseDir . $filenameOnly . '.*') ?: [];
                }
            }
            if (empty($candidates)) {
                $candidates = glob($baseDir . '*' . $fileId . '*') ?: [];
            }

            if (!empty($candidates)) {
                $absolute = $candidates[0];
                $displayName = basename($absolute);
                $extension = strtolower((string) pathinfo($absolute, PATHINFO_EXTENSION));
            }
        }

        if (!$absolute || !is_file($absolute)) {
            throw new InvalidArgumentException('Dosya fiziksel olarak bulunamadı');
        }

        $mime = @mime_content_type($absolute) ?: $this->guessMimeFromExtension($extension);
        $size = filesize($absolute) ?: null;
        if (!$mime) {
            $mime = 'application/octet-stream';
        }

        return [
            'id' => $fileId,
            'content_id' => $contentId,
            'name' => $displayName,
            'mime' => $mime,
            'extension' => $extension,
            'absolute_path' => $absolute,
            'size' => $size,
        ];
    }

    private function guessMimeFromExtension(string $extension): ?string
    {
        $map = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'csv' => 'text/csv',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
        ];

        $key = strtolower($extension);
        return $map[$key] ?? null;
    }

}
