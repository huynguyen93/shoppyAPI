<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShoeController extends BaseController
{
    public function listAction(Request $request)
    {
        $queries = $request->query->all();
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

//        $createListUrl = function ($params) use ($queries) {
//            return $this->generateUrl('app.product.list', array_merge($queries, $params));
//        };
//
//        $listOptions = [
//            'itemsPerPage' =>  [
//                'label' => 'Số sản phẩm 1 trang',
//                'options' => [
//                    ['label' => '10', 'value' => '10', 'link' => $createListUrl(['itemsPerPage' => 10])],
//                    ['label' => '20', 'value' => '20', 'link' => $createListUrl(['itemsPerPage' => 20])],
//                    ['label' => '30', 'value' => '30', 'link' => $createListUrl(['itemsPerPage' => 30])],
//                ],
//            ],
//            'sortBy' => [
//                'label' => 'Sắp xếp theo',
//                'options' => [
//                    ['label' => 'Nổi bật', 'value' => 'featured', 'link' => $createListUrl(['orderBy' => 'featured', 'order' => 'DESC'])],
//                    ['label' => 'Mới -> cũ', 'value' => 'releaseDate', 'link' => $createListUrl(['orderBy' => 'releaseDate', 'order' => 'DESC'])],
//                    ['label' => 'Bán đắt -> ế', 'value' => 'salesCount', 'link' => $createListUrl(['orderBy' => 'salesCount', 'order' => 'DESC'])],
//                    ['label' => 'Giá rẻ -> mắc', 'value' => 'priceLowest', 'link' => $createListUrl(['orderBy' => 'price', 'order' => 'ASC'])],
//                    ['label' => 'Giá mắc -> rẻ', 'value' => 'priceHighest', 'link' => $createListUrl(['orderBy' => 'price', 'order' => 'DESC'])],
//                ]
//            ]
//        ];

        $shoeCollection = $this->get('app.pagination_factory')
            ->createCollection($qb, $request, $limit, $page, 'app.product.list');

        return $this->createResponse([
            'category'       => $category,
            'brands'         => $category ? $brandManager->findByCategory($category) : $brandManager->findAll(),
            'selectedBrands' => $brands,
            'collection'     => $shoeCollection,
        ]);
    }

    public function detailAction($slug)
    {
        $shoe = $this->get('app.manager.shoe')->findOneBy(['slug' => $slug]);

        if (!$shoe) {
            throw new NotFoundHttpException(sprintf('Not found shoe with slug: "%s"!', $slug));
        }

        return $this->createResponse($shoe, ['detail']);
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
