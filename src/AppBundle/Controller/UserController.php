<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\CreateUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function newAction(Request $request)
    {
        $form = $this->createForm(CreateUserType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }

        throw new \InvalidArgumentException('Parameters are not valid');
    }
}
