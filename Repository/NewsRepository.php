<?php
/*
 * (c) Suhinin Ilja <iljasuhinin@gmail.com>
 */
namespace SIP\NewsBundle\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{
    /**
     * @param $slug
     * @return \Pagerfanta\Pagerfanta
     */
    public function getNewsByCategory($slug, $criteria, $orderBy)
    {
        $queryBuilder = $this->getCollectionQueryBuilder();

        $queryBuilder
            ->innerJoin("{$this->getAlias()}.category", 'c')
            ->andWhere('c.slug = :slug')
            ->setParameter('slug', $slug);

        $this->applyCriteria($queryBuilder, $criteria);
        $this->applySorting($queryBuilder, $orderBy);

        return $this->getPaginator($queryBuilder);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNewsQueryBuilder()
    {
        $queryBuilder = $this->getCollectionQueryBuilder();
        $queryBuilder->innerJoin("{$this->getAlias()}.category", 'c')
                     ->orderBy('c.position', 'ASC');

        $this->applyCriteria($queryBuilder, array('disabled' => 0));

        return $queryBuilder;
    }
}