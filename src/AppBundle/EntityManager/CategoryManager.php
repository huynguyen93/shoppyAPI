<?php

namespace AppBundle\EntityManager;

class CategoryManager extends AbstractManager
{
    public function getCategoryTree()
    {
        return $this->createQueryBuilder('category')
            ->where('category.parent IS null')
            ->orderBy('category.position')
            ->getQuery()
            ->getResult()
        ;
    }
}
