<?php

namespace App\Service;
use App\Repository\CategoryRepository;

class Categories 
{
    private $repo;
    public function __construct(CategoryRepository $repo)
    {
        $this->repo = $repo;
    }
    public function getAll() {
        return $this->repo->findAll();
    }
}
