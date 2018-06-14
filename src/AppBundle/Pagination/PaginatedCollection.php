<?php

namespace AppBundle\Pagination;

class PaginatedCollection
{
    private $items;

    private $itemsPerpage;

    private $total;

    private $count;

    private $totalPages;

    private $_links;

    public function __construct($items, $itemsPerPage, $total, $totalPages)
    {
        $this->items = $items;
        $this->itemsPerpage = $itemsPerPage;
        $this->total = $total;
        $this->totalPages = $totalPages;
        $this->count = count($items);
    }

    public function addLink($rel, $url)
    {
        $this->_links[$rel] = $url;
    }
}
