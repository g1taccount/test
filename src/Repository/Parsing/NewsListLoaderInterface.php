<?php

declare(strict_types=1);

namespace App\Repository\Parsing;

use App\Repository\Clients\HttpClientInterface;

/**
 * Interface NewsListLoaderInterface
 * @package App\Repository\Parsing
 */
interface NewsListLoaderInterface
{
    /**
     * NewsListLoaderInterface constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client);

    /**
     * @return array
     */
    public function loadNews(): array;
}