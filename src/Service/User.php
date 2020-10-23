<?php

namespace App\Service;
use App\Repository\UserRepository;

class User 
{
    private $repo;
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }
    public function getAll() {
        return $this->repo->findAll();
    }
}
