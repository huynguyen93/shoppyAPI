<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Color
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
     * @Serializer\Groups({"init", "detail"})
     */
    private $slug;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $code;

    /**
     * @var ShoeColor[]
     */
    private $shoeColors;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
}
