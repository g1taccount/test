<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\News;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NewsController
 * @package App\Controller
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/", name="news_list")
     *
     * @param NewsRepository $newsRepository
     * @return Response
     */
    public function list(NewsRepository $newsRepository): Response
    {
        return $this->render('news/list.html.twig', [
            'newsList' => $newsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/view/{id}", name="news_view")
     *
     * @param News $news
     * @return Response
     */
    public function view(News $news): Response
    {
        return $this->render('news/view.html.twig', [
            'news' => $news,
        ]);
    }
}
