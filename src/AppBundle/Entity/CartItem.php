<?php

namespace AppBundle\Entity;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class CartItem
{
    /**
     * @var int
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ShoeColorSize
     */
    private $shoeColorSize;

    /**
     * @var string
     * @Serializer\Expose()
     */
    private $name;

    /**
     * @var string
     * @Serializer\Expose()
     */
    private $size;

    /**
     * @var int
     * @Serializer\Expose()
     */
    private $quantity;

    /**
     * @var float
     * @Serializer\Expose()
     */
    private $price = 0;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $image;

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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
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
     * @param int $quantity
     */
    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart($cart)
    {
        $this->cart = $cart;
    }

    /**
     * @return ShoeColorSize
     */
    public function getShoeColorSize()
    {
        return $this->shoeColorSize;
    }

    /**
     * @param ShoeColorSize $shoeColorSize
     */
    public function setShoeColorSize($shoeColorSize)
    {
        $this->shoeColorSize = $shoeColorSize;
    }
}
