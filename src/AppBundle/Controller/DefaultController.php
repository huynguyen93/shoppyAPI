<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $data['categories'] = $this->get('app.manager.category')->getCategoryTree();

        $shoeManager = $this->get('app.manager.shoe');

        $data['shoes'] = [
            'featured' => $shoeManager->findFeaturedShoes(10, 0),
            'new' => $shoeManager->findNewShoes(10, 0),
            'bestSelling' => $shoeManager->findBestSelling(10, 0),
        ];

        return new Response(
            $this->get('jms_serializer')->serialize(
                $data,
                'json',
                SerializationContext::create()->setGroups(['init'])
            ),
            200,
            [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
