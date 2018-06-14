<?php

namespace AppBundle\EntityManager;

use AppBundle\Entity\Category;

class BrandManager extends AbstractManager
{
    public function findByCategory(Category $category = null)
    {
        $qb = $this->createQueryBuilder('brand');

        if (null === $category->getParent()) {
            $subCategories = $category->getChildren();

            $subCategoryIds = [];
            foreach ($subCategories as $subCategory) {
                $subCategoryIds[] = $subCategory->getId();
            }

            $qb->innerJoin('brand.shoes', 'shoe', 'WITH', 'shoe.category IN (:categories)')
                ->setParameter('categories', $subCategoryIds);
        } else {
            $qb->innerJoin('brand.shoes', 'shoe', 'WITH', 'shoe.category = :category')
                ->setParameter('category', $category);
        }

        return $qb->getQuery()->getResult();
    }
}
