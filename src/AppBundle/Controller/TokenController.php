<?php

namespace AppBundle\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TokenController extends Controller
{
    public function newAction(Request $request)
    {
        $username = $request->query->get('username');
//        $password = $request->query->get('password');

        $user = $this->get('app.manager.user')
            ->findOneBy([
                'username' => $username,
            ]);

        if (!$user) {
            throw new NotFoundHttpException('user not found');
        }

        try {
            $token = $this->get('lexik_jwt_authentication.encoder.abstract')
                ->encode([]);
        } catch (JWTEncodeFailureException $encodeFailureException) {
            return new JsonResponse([
                'message' => $encodeFailureException->getMessage(),
                'code' => $encodeFailureException->getCode()
            ], $encodeFailureException->getCode());
        }

        return new JsonResponse([
            'token' => $token
        ]);
    }
}
