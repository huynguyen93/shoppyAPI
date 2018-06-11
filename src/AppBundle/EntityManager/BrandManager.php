<?php

namespace AppBundle\EntityManager;

use AppBundle\Entity\Category;

class BrandManager extends AbstractManager
{
    public function findByCategory(Category $category = null)
    {
        return $this->createQueryBuilder('brand')
            ->innerJoin('brand.shoes', 'shoe', 'WITH', 'shoe.category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult()
        ;
    }
}
