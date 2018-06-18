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

    public function __construct($items, $currentPage, $total, $totalPages, $queries)
    {
        $this->items = $items;
        $this->currentPage = $currentPage;
        $this->total = $total;
        $this->totalPages = $totalPages;
        $this->count = count($items);
        $this->queries = $queries;
    }

    public function addLink($rel, $url)
    {
        $this->_links[$rel] = $url;
    }
}
