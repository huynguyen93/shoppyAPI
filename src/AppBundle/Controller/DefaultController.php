<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use Entity\Category;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    public function initAction(Request $request)
    {
        $cartId = (int) $request->query->get('cart');
        $cart = null;

        $data['categories'] = $this->get('app.manager.category')->getCategoryTree();
        $data['brands'] = $this->get('app.manager.brand')->findAll();

        $shoeManager = $this->get('app.manager.shoe');

        $data['sections'] = [
            ['name' => 'Sản phẩm nổi bật',  'items' => $shoeManager->findFeaturedShoes(10, 0)],
            ['name' => 'Sản phẩm mới',      'items' => $shoeManager->findNewShoes(10, 0)],
            ['name' => 'Sản phẩm bán chạy', 'items' => $shoeManager->findBestSelling(10, 0)],
        ];

        if ($cartId) {
            $cart = $this->get('app.manager.cart')->find($cartId);
        }

        if (null === $cart) {
            $cart = new Cart();
        }

        $data['cart'] = $cart;


        $router = $this->get('router');
        $generateEndpoint = function ($route, $params , $queries) use ($router) {
            $replacedParams = [];

            foreach ($params as $param) {
                $replacedParams[$param] = ':'.$param;
            }

            return [
                'url' => $router->generate($route, $replacedParams, UrlGeneratorInterface::ABSOLUTE_URL),
                'params' => array_combine($params, $params),
                'queries' => $queries,
            ];
        };

        $data['endpoints'] = [
            'init' => $generateEndpoint('app.init', [], ['cart']),
            'carts' => [
                'add'    => $generateEndpoint('app.cart.add', [], [
                    'cart'            => 'cart',
                    'shoeColorSizeId' => 'shoeColorSizeId',
                    'quantity'        => 'quantity',
                ]),
                'update' => $generateEndpoint('app.cart.update', ['cart', 'cartItem'], [
                    'quantity' => 'quantity',
                ]),
                'remove' => $generateEndpoint('app.cart.remove', ['cart'], [
                    'cartItems' => 'cartItems[]',
                ]),
                'detail' => $generateEndpoint('app.cart.detail', ['cart'], []),
            ],
            'products' => [
                'list' => $generateEndpoint('app.product.list', [], [
                    'category'       => 'category',
                    'selectedBrands' => 'selectedBrands[]',
                    'colors'         => 'colors',
                    'sizes'          => 'sizes',
                    'itemsPerPage'   => 'itemsPerPage',
                    'page'           => 'page',
                    'orderBy'        => 'orderBy',
                    'order'          => 'order',
                ]),
                'detail' => $generateEndpoint('app.product.detail', ['slug'], []),
            ],
        ];

        return $this->createResponse($data, ['Default', 'init']);
    }
}
