<?php

namespace AppBundle\Controller;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller
{
    public function createResponse($data, array $serializationGroups = [])
    {
        $context = SerializationContext::create();
        $context->setSerializeNull(true);

        if (!empty($serializationGroups)) {
            $context->setGroups($serializationGroups);
        }

        return new Response(
            $this->get('jms_serializer')->serialize(
                $data, 'json', $context),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}
