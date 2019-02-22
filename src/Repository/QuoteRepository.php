<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function getAllByCurrentPage(int $pageNum, int $limit = 10, int $offset = 0)
    {
        if ($offset === 0) {
            $offset = $pageNum * $limit - $limit;
        }

        return $this->getEntityManager()->createQuery('SELECT DISTINCT quote, author, series, author_face, author_face_image FROM App\Entity\Quote quote 
            JOIN quote.author author
            JOIN author.tagImage author_face
            JOIN author_face.image author_face_image
            JOIN quote.series series
            WHERE quote.status != :status_deleted AND quote.status != :status_pending ORDER BY quote.oldCreatedAt DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->setParameter('status_deleted', Quote::STATUS_DELETED)
                ->setParameter('status_pending', Quote::STATUS_PENDING)
                ->getResult();
    }

    public function getSearchByCurrentPage(string $keyword, int $pageNum, int $limit = 10, int $offset = 0)
    {
        if ($offset === 0) {
            $offset = $pageNum * $limit - $limit;
        }

        $select = "SELECT DISTINCT quote, author, series, author_face, author_face_image";
        $selectCount = "SELECT count(quote.id)";
        $repeatingDql = "FROM App\Entity\Quote quote 
            JOIN quote.author author
            JOIN author.tagImage author_face
            JOIN author_face.image author_face_image
            JOIN quote.series series
            WHERE (series.label = :search_keyword OR author.label = :search_keyword) AND quote.status != :status_deleted AND quote.status != :status_pending ORDER BY quote.oldCreatedAt DESC";

        $quotes = $this->getEntityManager()->createQuery($select.' '.$repeatingDql)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('status_deleted', Quote::STATUS_DELETED)
            ->setParameter('status_pending', Quote::STATUS_PENDING)
            ->setParameter('search_keyword', $keyword)
            ->getResult();

        $count = $this->getEntityManager()->createQuery($selectCount.' '.$repeatingDql)
            ->setParameter('status_deleted', Quote::STATUS_DELETED)
            ->setParameter('status_pending', Quote::STATUS_PENDING)
            ->setParameter('search_keyword', $keyword)
            ->getSingleScalarResult();

        return [
            $quotes,
            $count,
        ];
    }

    public function getAllQuoteCount(): int
    {
        return $this->createQueryBuilder('q')
            ->select('count(q.id)')
            ->where('q.status != :status_pending AND q.status != :status_deleted')
            ->setParameter('status_deleted', Quote::STATUS_DELETED)
            ->setParameter('status_pending', Quote::STATUS_PENDING)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
