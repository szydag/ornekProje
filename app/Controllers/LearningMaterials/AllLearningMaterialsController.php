<?php
declare(strict_types=1);

namespace App\Controllers\LearningMaterials;

use App\Controllers\BaseController;
use App\DTOs\LearningMaterials\AllLearningMaterialsQueryDTO;
use App\Services\LearningMaterials\AllLearningMaterialsService;

final class AllLearningMaterialsController extends BaseController
{
    public function __construct(
        private AllLearningMaterialsService $service = new AllLearningMaterialsService()
    ) {
    }

    // GET /apps/contents
    public function index()
    {
        $dto = AllLearningMaterialsQueryDTO::fromRequest($this->request);
        $data = $this->service->listAll($dto);

        if ($this->request->isAJAX() || $this->request->getHeaderLine('Accept') === 'application/json') {
            return $this->response->setJSON([
                'status' => 'ok',
                'data' => $data['items'],
                'meta' => $data['meta'],
            ]);
        }

        return view('app/admin-materials', [
            'title' => 'İçerikler - Admin Panel',
            'pageTitle' => 'İçerikler',
            'pageSubtitle' => 'Tüm içerikleri görüntüleyin ve yönetin',
            'contents' => $data['items'],
            'meta' => $data['meta'],
        ]);
    }

}
