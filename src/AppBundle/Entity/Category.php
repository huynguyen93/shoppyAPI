<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\Link;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Link(
 *     "self",
 *     route="app.product.list",
 *     params={"category": "object.getSlug()"}
 * )
 */
class Category
{
    /**
     * @var int
     */
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
     * @Serializer\Groups({"init"})
     */
    private $slug;

    /**
     * @var Category
     */
    private $parent;

    /**
     * @var Category[]
     * @Serializer\Expose()
     * @Serializer\Groups({"init"})
     */
    private $children;

    /**
     * @var Shoe[]
     */
    private $shoes;

    /**
     * @var int
     */
    private $position;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

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

    /**
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Category[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Category[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
}
