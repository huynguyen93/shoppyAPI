<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\VirtualProperty(
 *     "totalQuantity",
 *     exp="object.getTotalQuantity()",
 *  )
 */
class Cart
{
    /**
     * @var int
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @var CartItem[]
     * @Serializer\Expose()
     */
    private $items;

    /**
     * @var User
     * @Serializer\Expose()
     */
    private $user;

    /**
     * @var float
     * @Serializer\Expose()
     */
    private $price = 0;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return CartItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param CartItem[] $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function addItem(CartItem $item)
    {
        $this->items[] = $item;
        $item->setCart($this);
        $this->addPrice($item->getPrice());
    }

    /**
     * @param CartItem[] $items
     */
    public function removeItems(array $items)
    {
        foreach ($items as $item) {
            $this->removeItem($item);
        }
    }

    public function removeItem(CartItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * @param float $price
     */
    public function addPrice($price)
    {
        $this->price += $price;
    }

    public function updatePrice()
    {
        $this->price = 0;

        foreach ($this->items as $item) {
            $this->price += $item->getPrice() * $item->getQuantity();
        }
    }

    public function getTotalQuantity()
    {
        $quantity = 0;

        if (!$this->items->isEmpty()) {
            foreach ($this->items as $item) {
                $quantity += $item->getQuantity();
            }
        }

        return $quantity;
    }
}
