<?php

declare(strict_types=1);

namespace App\Repository;

use App\Document\Shorten;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\Bundle\MongoDBBundle\Repository\ServiceDocumentRepository;

class ShortenRepository extends ServiceDocumentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shorten::class);
    }

    public function incrementVisitors(string $shortenId)
    {
        $this->getDocumentManager()
            ->createQueryBuilder(Shorten::class)
            ->updateOne()
            ->field('id')->equals($shortenId)
            ->field('visitors')->inc(1)
            ->getQuery()
            ->execute();
    }
}
