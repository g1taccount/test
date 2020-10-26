<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\News;

/**
 * Interface SaveRepositoryInterface
 * @package App\Repository
 */
interface SaveRepositoryInterface
{
    /**
     * @param News $news
     */
    public function save(News $news): void;
}