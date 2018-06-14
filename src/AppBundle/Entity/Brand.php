<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\Link;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Link(
 *     "self",
 *     route="app.product.list",
 *     params={"brand": "object.getSlug()"}
 * )
 */
class Brand
{
    /** @var int */
    private $id;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $name;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $slug;

    /**
     * @var Shoe[]
     */
    private $shoes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return Shoe[]
     */
    public function getShoes()
    {
        return $this->shoes;
    }

    /**
     * @param Shoe[] $shoes
     */
    public function setShoes($shoes)
    {
        $this->shoes = $shoes;
    }
}
