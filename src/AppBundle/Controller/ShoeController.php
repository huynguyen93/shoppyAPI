<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoeController extends FOSRestController
{
    public function listAction(Request $request)
    {
        $limit    = $request->query->get('itemsPerPage', 10);
        $page     = $request->query->get('page', 1);
        $category = $request->query->get('category');
        $brand    = $request->query->get('brand');
        $orderBy  = $request->query->get('orderBy');
        $order    = $request->query->get('order');
        $offset   = $limit * ($page - 1);

        $categoryManager = $this->get('app.manager.category');
        $brandManager = $this->get('app.manager.brand');
        $shoeManager = $this->get('app.manager.shoe');

        if ($category) {
            $category = $categoryManager->findOneBy(['slug' => $category]);

            if (!$category) {
                return [];
            }
        }

        if ($brand) {
            $brand = $brandManager->findOneBy(['slug' => $brand]);

            if (!$brand) {
                return [];
            }
        }

        $qb = $shoeManager->findByQueryBuilder($category, $brand, $orderBy, $order, $limit, $offset);

        return new Response(
            $this->get('jms_serializer')->serialize([
                    'category'   => $category,
                    'brand'      => $brand,
                    'brands'     => $category ? $brandManager->findByCategory($category) : null,
                    'collection' => $this->get('app.pagination_factory')->createCollection($qb, $request, $limit, $page, 'app.shoe.list')
                ],
                'json'
            ),
            200,
            ['Content-Type' => 'application/json']
        );
    }

    public function detailAction($slug)
    {
        $shoe = $this->get('app.manager.shoe')->findOneBy(['slug' => $slug]);

        if (!$shoe) {
            throw new NotFoundHttpException(sprintf('Not found shoe with slug: "%s"!', $slug));
        }

        return new Response(
            $this->get('jms_serializer')->serialize($shoe, 'json', SerializationContext::create()->setGroups(['detail'])),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
