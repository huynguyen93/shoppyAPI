<?php

namespace AppBundle\Entity;

use AppBundle\Annotation\Asset;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Asset(fields={"sm", "md", "lg", "xl"})
 */
class ShoeColorImage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var ShoeColor
     */
    private $shoeColor;

    /**
     * @var int
     */
    private $position;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $sm;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"init", "detail"})
     */
    private $md;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
     */
    private $lg;

    /**
     * @var string
     * @Serializer\Expose()
     * @Serializer\Groups({"detail"})
     */
    private $xl;

    /**
     * @return string
     */
    public function getSm()
    {
        return $this->sm;
    }

    /**
     * @param string $sm
     */
    public function setSm($sm)
    {
        $this->sm = $sm;
    }

    /**
     * @return string
     */
    public function getMd()
    {
        return $this->md;
    }

    /**
     * @param string $md
     */
    public function setMd($md)
    {
        $this->md = $md;
    }

    /**
     * @return string
     */
    public function getLg()
    {
        return $this->lg;
    }

    /**
     * @param string $lg
     */
    public function setLg($lg)
    {
        $this->lg = $lg;
    }

    /**
     * @return string
     */
    public function getXl()
    {
        return $this->xl;
    }

    /**
     * @param string $xl
     */
    public function setXl($xl)
    {
        $this->xl = $xl;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
}
