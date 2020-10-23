<?php

namespace App\Service;
use App\Repository\ProductRepository;

class Product 
{
    private $repo;
    public function __construct(ProductRepository $repo)
    {
        $this->repo = $repo;
    }
    public function getAll() {
        return $this->repo->findAll();
    }
}
