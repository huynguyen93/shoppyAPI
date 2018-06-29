<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class ShoeColorSize
{
    /**
     * @var int
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
     */
    private $id;

    /**
     * @var ShoeColor
     * @Serializer\Expose()
     */
    private $shoeColor;

    /**
     * @var int
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
     */
    private $size;

    /**
     * @var int
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
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
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
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
     * @return ShoeColor
     */
    public function getShoeColor()
    {
        return $this->shoeColor;
    }

    /**
     * @param ShoeColor $shoeColor
     */
    public function setShoeColor($shoeColor)
    {
        $this->shoeColor = $shoeColor;
    }
}
