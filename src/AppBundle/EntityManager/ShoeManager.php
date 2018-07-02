<?php

namespace AppBundle\EntityManager;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Category;
use AppBundle\Pagination\PaginationFactory;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ShoeManager extends AbstractManager
{
    /**
     * @var PaginationFactory
     */
    private $paginationFactory;

    /**
     * @var CategoryManager
     */
    private $categoryManager;

    public function __construct(ManagerRegistry $registry, $class, PaginationFactory $paginationFactory, CategoryManager $categoryManager)
    {
        parent::__construct($registry, $class);
        $this->paginationFactory = $paginationFactory;
        $this->categoryManager = $categoryManager;
    }

    public function findAllQueryBuilder($limit, $offset)
    {
        return $this->createQueryBuilder('shoe')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
        ;
    }

    public function findByQueryBuilder(
        Category $category = null,
        array $brands = [],
        $orderBy = null,
        $order = 'ASC',
        $limit,
        $offset
    ) {
        $qb = $this->findAllQueryBuilder($limit, $offset)
            ->leftJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.category', 'category', 'WITH')
            ->leftJoin('shoe.shoeColors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->leftJoin('shoeColor.sizes', 'shoeColorSize', 'WITH')
            ->addSelect('brand')
            ->addSelect('category')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
            ->addSelect('shoeColorSize')
        ;

        if ($category) {
            if (null === $category->getParent()) {
                $category = $this->categoryManager->findBy(['parent' => $category]);

                $qb->andWhere('shoe.category IN (:category)')
                    ->setParameter('category', $category);
            } else {
                $qb->andWhere('shoe.category = :category')
                    ->setParameter('category', $category);
            }
        }

        if ($brands) {
            $qb->andWhere('shoe.brand IN (:brands)')
                ->setParameter('brands', $brands);
        }

        if ($orderBy) {
            $qb->orderBy('shoe.'.$orderBy, $order);
        }

        $qb->addOrderBy('shoe.id', 'ASC');

        return $qb;
    }

    public function findAllOrderedByPositionQueryBuilder($limit, $offset)
    {
        return $this->findAllQueryBuilder($limit, $offset)
            ->orderBy('shoe.position')
        ;
    }

    public function findFeaturedShoes($limit, $offset)
    {
        $qb = $this->findAllQueryBuilder($limit, $offset)
            ->andWhere('shoe.featured > 0')
            ->orderBy('shoe.featured', 'DESC')
            ->innerJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.shoeColors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->addSelect('brand')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
        ;

        return $this->getPaginatedShoes($qb);
    }

    public function findNewShoes($limit, $offset)
    {
        $qb = $this->findAllQueryBuilder($limit, $offset)
            ->orderBy('shoe.releaseDate', 'DESC')
            ->innerJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.shoeColors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->addSelect('brand')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
        ;

        return $this->getPaginatedShoes($qb);
    }

    public function findBestSelling($limit, $offset)
    {
        $qb = $this->findAllQueryBuilder($limit, $offset)
            ->orderBy('shoe.salesCount', 'DESC')
            ->innerJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.shoeColors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->addSelect('brand')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
        ;

        return $this->getPaginatedShoes($qb);
    }

    public function findOneBy(array $criteria)
    {
        $qb = $this->createQueryBuilder('shoe')
            ->leftJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.category', 'category', 'WITH')
            ->leftJoin('shoe.shoeColors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->leftJoin('shoeColor.sizes', 'shoeColorSize', 'WITH')
            ->addSelect('brand')
            ->addSelect('category')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
            ->addSelect('shoeColorSize')
        ;

        foreach ($criteria as $column => $value) {
            $qb->andWhere('shoe.'.$column.' = :'.$column)->setParameter($column, $value);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * Join and limit query need Paginator to get correct result
     *
     * @param QueryBuilder $queryBuilder
     * @return array
     */
    private function getPaginatedShoes(QueryBuilder $queryBuilder)
    {
        $paginator = new Paginator($queryBuilder);
        $shoes     = [];

        foreach ($paginator as $shoe) {
            $shoes[] = $shoe;
        }

        return $shoes;
    }
}
