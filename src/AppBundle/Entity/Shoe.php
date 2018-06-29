<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\Link;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Link(
 *     "self",
 *     route="app.product.detail",
 *     params={"slug": "object.getSlug()"}
 * )
 */
class Shoe
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $category;

    /**
     * @var Brand
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $brand;

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
     * @var float
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $price;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $description;

    /**
     * @var ShoeColor[]
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $shoeColors;

    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $featured;

    /**
     * @var int
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $salesCount;

    /**
     * @var \DateTime
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $releaseDate;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param Brand $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
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
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return ShoeColor[]
     */
    public function getShoeColors()
    {
        return $this->shoeColors;
    }

    /**
     * @param ShoeColor[] $shoeColors
     */
    public function setShoeColors($shoeColors)
    {
        $this->shoeColors = $shoeColors;
    }

    /**
     * @param ShoeColor[] $colors
     */
    public function setColors($colors)
    {
        $this->colors = $colors;
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
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param \DateTime $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return int
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * @param int $featured
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
    }

    /**
     * @return int
     */
    public function getSalesCount()
    {
        return $this->salesCount;
    }

    /**
     * @param int $salesCount
     */
    public function setSalesCount($salesCount)
    {
        $this->salesCount = $salesCount;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    public function isFeatured()
    {
        return $this->featured > 0;
    }
}
