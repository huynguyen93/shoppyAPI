<?php

namespace AppBundle\Pagination;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class PaginationFactory
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function createCollection(
        QueryBuilder $queryBuilder,
        Request $request,
        $maxPerPage,
        $page,
        $route,
        array $routeParams = []
    ) {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerFanta = new Pagerfanta($adapter);
        $pagerFanta->setMaxPerPage($maxPerPage);
        $pagerFanta->setCurrentPage($page);

        $shoes = [];

        foreach ($pagerFanta->getCurrentPageResults() as $shoe) {
            $shoes[] = $shoe;
        }

        $paginatedCollection = new PaginatedCollection(
            $shoes,
            $maxPerPage,
            $page,
            $pagerFanta->getNbResults(),
            $pagerFanta->getNbPages()
        );

        $routeParams = array_merge($routeParams, $request->query->all());
        $createLinkUrl = function ($pageNum) use ($route, $routeParams) {
            return $this->router->generate($route, array_merge($routeParams, ['page' => $pageNum]));
        };

        $paginatedCollection->addLink('self', $createLinkUrl($page));
        $paginatedCollection->addLink('first', $createLinkUrl(1));
        $paginatedCollection->addLink('last', $createLinkUrl($pagerFanta->getNbPages()));

        if ($pagerFanta->hasNextPage()) {
            $paginatedCollection->addLink('next', $createLinkUrl($pagerFanta->getNextPage()));
        }

        if ($pagerFanta->hasPreviousPage()) {
            $paginatedCollection->addLink('prev', $createLinkUrl($pagerFanta->getPreviousPage()));
        }

        return $paginatedCollection;
    }
}
