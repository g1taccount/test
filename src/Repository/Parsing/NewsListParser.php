<?php

declare(strict_types=1);

namespace App\Repository\Parsing;

use App\Entity\News;
use App\Repository\Clients\HttpClientInterface;
use DateTime;
use DateTimeInterface;

/**
 * Class NewsListParser
 * @package App\Repository\Parsing
 */
class NewsListParser implements NewsListLoaderInterface
{
    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $client;

    /**
     * NewsListParser constructor.
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     * @throws ParseException
     */
    public function loadNews(): array
    {
        $news = [];
        foreach ($this->getUrlList() as $hashId => $url) {
            $content = $this->client->get($url);
            $news[] = (new News())
                ->setHashId($hashId)
                ->setTitle($this->getTitle($content))
                ->setDescription($this->getDescription($content))
                ->setCategory($this->getCategory($content))
                ->setUrl($url)
                ->setImage($this->getImage($content))
                ->setSubtitle($this->getSubtitle($content))
                ->setDateTime($this->getDateTime($content));
        }

        return array_slice($news, 0, 15);
    }

    /**
     * @return array
     * @throws ParseException
     */
    protected function getUrlList(): array
    {
        $domain = getenv('SITE_NAME');;
        $timestamp = time();
        $url = "https://www.{$domain}.ru/v10/ajax/get-news-feed/project/{$domain}news/lastDate/{$timestamp}/limit/25?_={$timestamp}000";

        $response = $this->client->get($url);

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new ParseException(json_last_error_msg());
        }

        $urls = [];
        foreach ($data['items'] as $item) {
            preg_match_all('#<a href="(.*(www.' . $domain . '.ru|sport' . $domain . '.ru).*)".*id="id_newsfeed_(.*)"#Umis', $item['html'], $matches, PREG_SET_ORDER);
            if ($matches) {
                $urls[$matches[0][3]] = $matches[0][1];
            }
        }

        return $urls;
    }

    /**
     * @param string $content
     * @return string
     */
    protected function getTitle(string $content): string
    {
        preg_match('#js-slide-title.*>(.*)<#Umis', $content, $matches);
        return $matches[1];
    }

    /**
     * @param string $content
     * @return string
     */
    protected function getDescription(string $content): string
    {
        preg_match('#article__text(.*)(l-col-right|article__clear)#Umis', $content, $matches);
        preg_match_all('#(<p>[^<].*</p>).*#Umis', $matches[1], $matches2);
        return implode('', $matches2[1]);
    }

    /**
     * @param string $content
     * @return string
     */
    protected function getCategory(string $content): string
    {
        preg_match('#data-category="(.*)"#Umis', $content, $matches);
        return $matches[1];
    }

    /**
     * @param string $content
     * @return string|null
     */
    protected function getSubtitle(string $content): ?string
    {
        preg_match('#article__text__overview".*><span>(.*)</span>#Umis', $content, $matches);
        return $matches[1] ?? null;
    }

    /**
     * @param string $content
     * @return string|null
     */
    protected function getImage(string $content): ?string
    {
        preg_match('#article__main-image.*<img src="(.*)".*article__main-image__image.*>#Umis', $content, $matches);
        return $matches[1] ?? null;
    }

    /**
     * @param string $content
     * @return DateTimeInterface|null
     */
    protected function getDateTime(string $content): ?DateTimeInterface
    {
        preg_match('#class="article__header__date".*content="(.*)"#Umis', $content, $matches);
        if (isset($matches[1])) {
            $dateTime = DateTime::createFromFormat('Y-m-d\TH:i:sP', $matches[1]);
        } else {
            $dateTime = null;
        }

        return $dateTime;
    }
}
