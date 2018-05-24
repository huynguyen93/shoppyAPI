<?php

namespace AppBundle\EntityManager;

use AppBundle\Entity\Category;
use AppBundle\Pagination\PaginationFactory;
use Doctrine\Common\Persistence\ManagerRegistry;
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
        $qb = $this->findAllQueryBuilder($limit, $offset);

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
            ->andWhere('shoe.featuredPriority > 0')
            ->orderBy('shoe.featuredPriority', 'DESC')
            ->innerJoin('shoe.brand', 'brand', 'WITH')
            ->leftJoin('shoe.colors', 'shoeColor', 'WITH')
            ->leftJoin('shoeColor.images', 'shoeColorImage', 'WITH')
            ->addSelect('brand')
            ->addSelect('shoeColor')
            ->addSelect('shoeColorImage')
        ;

        // limit and join queries don't work well together
        // Paginator to the rescue
        $paginator = new Paginator($qb);
        $shoes     = [];

        foreach ($paginator as $shoe) {
            $shoes[] = $shoe;
        }

        return $shoes;
    }
}
