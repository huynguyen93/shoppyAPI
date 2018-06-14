<?php

namespace AppBundle\Pagination;

class PaginatedCollection
{
    private $items;

    private $itemsPerPage;

    private $currentPage;

    private $total;

    private $count;

    private $totalPages;

    private $_links;

    public function __construct($items, $itemsPerPage, $currentPage, $total, $totalPages)
    {
        $this->items = $items;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
        $this->total = $total;
        $this->totalPages = $totalPages;
        $this->count = count($items);
    }

    public function addLink($rel, $url)
    {
        $this->_links[$rel] = $url;
    }
}
