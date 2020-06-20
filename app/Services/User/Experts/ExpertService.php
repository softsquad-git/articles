<?php

namespace App\Services\User\Experts;

use App\Models\Users\Experts\Expert;
use App\Models\Users\Experts\ExpertQuery;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\User\Experts\ExpertRepository;
use \Exception;
use Illuminate\Support\Facades\Auth;

class ExpertService
{
    /**
     * @var ExpertRepository
     */
    private $expertRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * ExpertService constructor.
     * @param CategoryRepository $categoryRepository
     * @param ExpertRepository $expertRepository
     */
    public function __construct(CategoryRepository $categoryRepository, ExpertRepository $expertRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->expertRepository = $expertRepository;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws Exception
     */
    public function registerExpert(array $data)
    {
        $data['user_id'] = Auth::id();
        $categoryId = $data['category_id'];
        $this->categoryRepository->findCategory($categoryId);
        $expert = $this->expertRepository->findExpertUser($categoryId);
        if (!empty($expert)) {
            if ($expert->status = 1)
                throw new Exception('Jesteś już ekspertem w tej kategorii');
            else
                throw new Exception('Twoja prośba oczekuje na akceptację');
        }
        $dataNewExpert = [
            'user_id' => Auth::id(),
            'category_id' => $categoryId
        ];
        $newExpert = Expert::create($dataNewExpert);
        $newExpertQuery = ExpertQuery::create($data);
        if (empty($newExpert)) {
            $newExpertQuery->delete();
            throw new Exception('Expert created error');
        }
        if (empty($newExpertQuery)) {
            $newExpert->delete();
            throw new Exception('Query expert created error');
        }
        return $newExpert;
    }

    /**
     * @param int $categoryId
     * @return bool|null
     * @throws Exception
     */
    public function remove(int $categoryId): ?bool
    {
        return $this->expertRepository->findExpertUser($categoryId)->delete();
    }
}
