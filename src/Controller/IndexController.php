<?php

namespace App\Controller;

use App\Repository\QuoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    protected $quoteRepository;

    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function index(Request $request)
    {
        $pageNum = $this->getPageNum($request);
        if ($pageNum === null) {
            return $this->redirect('/');
        }

        $quoteCount = $this->quoteRepository->getAllQuoteCount();
        if (($pageNum * 10 - 10 + 1) > $quoteCount) {
            return $this->redirect('/');
        }
        $maxPage = floor($quoteCount/10);
        $result = $this->quoteRepository->getAllByCurrentPage($pageNum);

        return $this->render("home.html.twig", [
            'quotes' => $result,
            'quote_count' => $quoteCount,
            'current_page' => $pageNum,
            'max_page' => $maxPage,
        ]);
    }

    public function search(Request $request, string $keyword)
    {
        $keyword = urldecode($keyword);
        $pageNum = $this->getPageNum($request);
        if ($pageNum === null) {
            return $this->redirect('/');
        }

        list($result, $quoteCount) = $this->quoteRepository->getSearchByCurrentPage($keyword, $pageNum);
        if (($pageNum * 10 - 10 + 1) > $quoteCount) {
            return $this->redirect('/');
        }
        $maxPage = floor($quoteCount/10);

        return $this->render("home.html.twig", [
            'search_keyword' => $keyword,
            'quotes' => $result,
            'quote_count' => $quoteCount,
            'current_page' => $pageNum,
            'max_page' => $maxPage,
        ]);
    }

    private function getPageNum(Request $request): ?int
    {
        $pageNum = $request->query->get('p');
        if ($pageNum !== null && (empty($pageNum) || !is_numeric($pageNum))) {
            $pageNum = null;
        } elseif ($pageNum === null) {
            $pageNum = 1;
        }

        return $pageNum;
    }
}

