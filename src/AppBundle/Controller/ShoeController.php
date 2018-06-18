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
        $this->setDefaultQueries($request);

        $limit    = (int) $request->query->get('itemsPerPage');
        $page     = (int) $request->query->get('page');
        $category = $request->query->get('category');
        $brands   = $request->query->get('selectedBrands', []);
        $orderBy  = $request->query->get('orderBy');
        $order    = $request->query->get('order');
        $offset   = (int) $limit * ($page - 1);

        $categoryManager = $this->get('app.manager.category');
        $brandManager = $this->get('app.manager.brand');
        $shoeManager = $this->get('app.manager.shoe');

        if ($category) {
            $category = $categoryManager->findOneBy(['slug' => $category]);

            if (!$category) {
                return [];
            }
        }

        if ($brands) {
            $brands = $brandManager->findBy(['slug' => $brands]);

            if (!$brands) {
                return [];
            }
        }

        $qb = $shoeManager->findByQueryBuilder($category, $brands, $orderBy, $order, $limit, $offset);

        return new Response(
            $this->get('jms_serializer')->serialize([
                    'category'       => $category,
                    'brands'         => $category ? $brandManager->findByCategory($category) : $brandManager->findAll(),
                    'selectedBrands' => $brands,
                    'collection'     => $this->get('app.pagination_factory')->createCollection($qb, $request, $limit, $page, 'app.product.list')
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

    private function setDefaultQueries(Request $request)
    {
        if (!$request->query->get('itemsPerPage')) {
            $request->query->set('itemsPerPage', 10);
        }

        if (!$request->query->get('page')) {
            $request->query->set('page', 1);
        }

        if (!$request->query->get('orderBy')) {
            $request->query->set('orderBy', 'featured');
        }

        if (!$request->query->get('order')) {
            $request->query->set('order', 'DESC');
        }
    }
}
