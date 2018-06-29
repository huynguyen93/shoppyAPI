<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\Link;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Link(
 *     "self",
 *     route="app.product.detail",
 *     params={"slug": "object.getShoe().getSlug()", "color": "object.getSlug()"}
 * )
 */
class ShoeColor
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Shoe
     */
    private $shoe;

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
     * @var Color
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $color;

    /**
     * @var ShoeColorImage[]
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $images;

    /**
     * @var ShoeColorSize[]
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
     */
    private $sizes;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Shoe
     */
    public function getShoe()
    {
        return $this->shoe;
    }

    /**
     * @param Shoe $shoe
     */
    public function setShoe($shoe)
    {
        $this->shoe = $shoe;
    }

    /**
     * @return ShoeColorImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ShoeColorImage[] $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return ShoeColorSize[]
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * @param ShoeColorSize[] $sizes
     */
    public function setSizes($sizes)
    {
        $this->sizes = $sizes;
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
     * @return Color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param Color $color
     */
    public function setColor($color)
    {
        $this->color = $color;
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
}
