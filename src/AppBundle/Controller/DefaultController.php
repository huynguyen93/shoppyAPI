<?php

namespace AppBundle\Controller;

use Entity\Category;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
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
            ['name' => 'Sản phẩm nổi bật', 'items' => $shoeManager->findFeaturedShoes(10, 0)],
            ['name' => 'Sản phẩm mới', 'items' => $shoeManager->findNewShoes(10, 0)],
            ['name' => 'Sản phẩm bán chạy', 'items' => $shoeManager->findBestSelling(10, 0)],
        ];

        if ($cartId) {
            $cart = $this->get('app.manager.cart')->find($cartId);
        }

        $data['cart'] = $cart;

        $data['endpoints'] = [
            'init' => [
                'url'     => $this->generateUrl('app.init', [], UrlGeneratorInterface::ABSOLUTE_URL),
                'params'  => [],
                'queries' => ['cart' => 'cart'],
            ],
            'carts' => [
                'add' => [
                    'url'     => $this->generateUrl('app.cart.add', [], UrlGeneratorInterface::ABSOLUTE_URL),
                    'params'  => [],
                    'queries' => [
                        'cart'            => 'cart',
                        'shoeColorSizeId' => 'shoeColorSizeId',
                        'quantity'        => 'quantity',
                    ],
                ],
                'remove' => [
                    'url' => $this->generateUrl('app.cart.remove', ['cart' => ':cartId'], UrlGeneratorInterface::ABSOLUTE_URL),
                    'params'  => ['cartId' => 'cartId'],
                    'queries' => ['cartItems' => 'cartItems[]'],
                ],
                'detail' => [
                    'url'     => $this->generateUrl('app.cart.detail', ['cart' => ':cartId'], UrlGeneratorInterface::ABSOLUTE_URL),
                    'params'  => ['cartId' => 'cartId'],
                    'queries' => [],
                ],
            ],
            'products' => [
                'list' => [
                    'url'     => $this->generateUrl('app.product.list', [], UrlGeneratorInterface::ABSOLUTE_URL),
                    'params'  => [],
                    'queries' => [
                        'category'       => 'category',
                        'selectedBrands' => 'selectedBrands[]',
                        'colors'         => 'colors',
                        'sizes'          => 'sizes',
                        'itemsPerPage'   => 'itemsPerPage',
                        'page'           => 'page',
                        'orderBy'        => 'orderBy',
                        'order'          => 'order',
                    ]
                ],
                'detail' => [
                    'url'     => $this->generateUrl('app.product.detail', ['slug' => ':slug'], UrlGeneratorInterface::ABSOLUTE_URL),
                    'params'  => ['slug' => 'slug'],
                    'queries' => [],
                ],
            ],
        ];

        return new Response(
            $this->get('jms_serializer')->serialize(
                $data,
                'json',
                SerializationContext::create()->setGroups(['init'])->setSerializeNull(true)
            ),
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
