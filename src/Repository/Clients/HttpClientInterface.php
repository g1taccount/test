<?php

declare(strict_types=1);

namespace App\Repository\Clients;

/**
 * Interface HttpClientInterface
 * @package App\Repository\Clients
 */
interface HttpClientInterface
{
    /**
     * @param string $url
     * @return bool|string
     */
    public function get(string $url);

    /**
     * @param string $url
     * @return bool|string
     */
    public function post(string $url);

    /**
     * @param string $url
     * @return bool|string
     */
    public function patch(string $url);

    /**
     * @param string $url
     * @return bool|string
     */
    public function delete(string $url);
}