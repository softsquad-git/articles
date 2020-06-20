<?php

namespace App\Repositories\User\Experts;

use App\Models\Users\Experts\Expert;
use App\Repositories\Categories\CategoryRepository;
use App\Repositories\User\UserRepository;
use \Exception;
use Illuminate\Support\Facades\Auth;

class ExpertRepository
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository, CategoryRepository $categoryRepository)
    {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories()
    {
        $experts = Expert::where([
            'user_id' => Auth::id(),
            'status' => 1
        ])
            ->get();
        $categoriesIds = [];
        foreach ($experts as $expert) {
            $categoriesIds[] = $expert->category_id;
        }
        return $this->categoryRepository->getFewCategories($categoriesIds);
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function findExpertUser(int $categoryId)
    {
        return Expert::where([
            'user_id' => Auth::id(),
            'category_id' => $categoryId
        ])->first();
    }

    /**
     * @param int $expertId
     * @return mixed
     * @throws Exception
     */
    public function findExpert(int $expertId)
    {
        $expert = Expert::find($expertId);
        if (empty($expert))
            throw new Exception('Expert not found');
        return $expert;
    }
}
