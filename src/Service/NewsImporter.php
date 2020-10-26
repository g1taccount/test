<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\News;
use App\Repository\NewsRepository;
use App\Repository\Parsing\NewsListLoaderInterface;

/**
 * Class NewsImporter
 * @package App\Repository\Clients
 */
class NewsImporter implements NewsImporterInterface
{
    /**
     * @var NewsListLoaderInterface
     */
    protected NewsListLoaderInterface $newsListLoader;

    /**
     * @var NewsRepository
     */
    protected NewsRepository $newsRepository;

    /**
     * NewsImporter constructor.
     * @param NewsListLoaderInterface $newsListLoader
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsListLoaderInterface $newsListLoader, NewsRepository $newsRepository)
    {
        $this->newsListLoader = $newsListLoader;
        $this->newsRepository = $newsRepository;
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function run(): void
    {
        /** @var News $news */
        foreach ($this->newsListLoader->loadNews() as $news) {
            $current = $this->newsRepository->findOneBy(['hashId' => $news->getHashId()]);
            if ($current) {
                $current
                    ->setTitle($news->getTitle())
                    ->setDescription($news->getDescription())
                    ->setCategory($news->getCategory())
                    ->setUrl($news->getUrl())
                    ->setImage($news->getImage())
                    ->setSubtitle($news->getSubtitle())
                    ->setDateTime($news->getDateTime());
                $this->newsRepository->update($news);
            } else {
                $this->newsRepository->save($news);
            }
        }
    }
}