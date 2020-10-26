<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\NewsRepository;
use App\Repository\Parsing\ParsableOneNewsInterface;
use App\Repository\Parsing\NewsListLoaderInterface;

/**
 * Interface NewsImporterInterface
 * @package App\Service
 */
interface NewsImporterInterface
{
    /**
     * NewsImporterInterface constructor.
     * @param NewsListLoaderInterface $newsListLoader
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsListLoaderInterface $newsListLoader, NewsRepository $newsRepository);

    /**
     * @return void
     */
    public function run(): void;
}