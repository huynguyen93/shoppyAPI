<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\CartItem;
use AppBundle\Entity\ShoeColorSize;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartController extends Controller
{
    public function addAction(Request $request)
    {
        $cartId          = (int) $request->query->get('cart');
        $shoeColorSizeId = (int) $request->query->get('shoeColorSize');
        $quantity        = (int) $request->query->get('quantity');

        if (!$shoeColorSizeId) {
            throw new HttpException('missing parameter "shoeColorSize"');
        }

        $cartManager = $this->get('app.manager.cart');
        $em          = $this->get('doctrine')->getManager();

        /** @var ShoeColorSize $shoeColorSize */
        $shoeColorSize = $this->get('app.manager.shoe_color_size')->find($shoeColorSizeId);

        if (!$quantity || $quantity > $shoeColorSize->getQuantity()) {
            throw new HttpException('invalid parameter "quantity"');
        }

        if (!$cartId) {
            $cart = new Cart();
        } else {
            /** @var Cart $cart */
            $cart = $cartManager->find($cartId);

            if (!$cart) {
                throw new HttpException('invalid parameter "cart"');
            }
        }

        /** @var CartItem $cartItem */
        $cartItem = null;

        foreach ($cart->getItems() as $item) {
            if ($item->getShoeColorSize() === $shoeColorSize) {
                $cartItem = $item;
                $cartItem->addQuantity($quantity);
                $cart->addPrice($item->getPrice() * $quantity);
            }
        }

        if (null === $cartItem) {
            $cartItem = new CartItem();
            $cartItem->setShoeColorSize($shoeColorSize);
            $cartItem->setQuantity($quantity);
            $cartItem->setSize($shoeColorSize->getSize());
            $cartItem->setPrice($shoeColorSize->getShoePrice() * $quantity);
            $cartItem->setName($shoeColorSize->getShoeColorName());
            $cartItem->setImage($shoeColorSize->getShoeColorFirstSmImage());

            $cart->addItem($cartItem);
            $em->persist($cart);
        }

        $em->persist($cartItem);
        $em->flush();

        return new Response(
            $this->get('jms_serializer')->serialize($cart, 'json'), 200, ['Content-Type' => 'application/json']
        );
    }
}
