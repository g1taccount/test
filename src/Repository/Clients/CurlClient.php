<?php

declare(strict_types=1);

namespace App\Repository\Clients;

/**
 * Class CurlClient
 * @package App\Repository\Clients
 */
class CurlClient implements HttpClientInterface
{
    /**
     * @var string
     */
    public string $response;

    /**
     * @var int
     */
    public int $code;

    /**
     * @var string
     */
    public string $error;

    /**
     * @param string $url
     * @return bool|string
     */
    public function get(string $url)
    {
        $headers = [
            'Content-Type: application/json',
            'user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.75 Safari/537.36',
        ];
        return $this->baseRequest($url, 'GET', null, $headers);
    }

    /**
     * @param string $url
     * @param array $data
     * @return bool|string
     */
    public function post(string $url, array $data = [])
    {
        return $this->baseRequest($url, 'POST', json_encode($data));
    }

    /**
     * @param string $url
     * @param array $data
     * @return bool|string
     */
    public function patch(string $url, array $data = [])
    {
        return $this->baseRequest($url, 'PATCH', json_encode($data));
    }

    /**
     * @param string $url
     * @return bool|string
     */
    public function delete(string $url)
    {
        return $this->baseRequest($url, 'DELETE');
    }

    /**
     * @param string $url
     * @param string $method
     * @param null $post
     * @param array $headers
     * @return bool|string
     */
    protected function baseRequest(string $url, string $method = 'GET', $post = null, $headers = [])
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } elseif ($method == 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        } elseif ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }

        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $this->response = curl_exec($ch);
        $this->code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->error = curl_error($ch);

        curl_close($ch);

        return $this->response;
    }
}