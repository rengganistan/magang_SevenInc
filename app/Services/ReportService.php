<?php

namespace App\Services;

use App\Repositories\ReportRepository;

class ReportService
{
    protected $repository;

    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    public function stock()
    {
        return $this->repository->stock();
    }

    public function incoming()
    {
        return $this->repository->incoming();
    }

    public function outgoing()
    {
        return $this->repository->outgoing();
    }
}
