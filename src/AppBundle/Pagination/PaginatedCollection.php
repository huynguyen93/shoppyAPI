<?php

namespace AppBundle\Pagination;

class PaginatedCollection
{
    private $items;

    private $currentPage;

    private $total;

    private $count;

    private $totalPages;

    private $queries;

    private $_links;

    private $viewOptions;

    public function __construct($items, $currentPage, $total, $totalPages, array $queries, array $viewOptions)
    {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->total = $total;
        $this->totalPages = $totalPages;
        $this->count = count($items);
        $this->queries = $queries;
        $this->viewOptions = $viewOptions;
    }

    public function addLink($rel, $url)
    {
        $this->_links[$rel] = $url;
    }
}
