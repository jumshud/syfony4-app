<?php

namespace App\Controller;

use App\Service\SocialLogin;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends BaseController
{
    /**
     * @Route("/login", name="login_index")
     *
     * @param Request $request
     * @param LoggerInterface $logger
     * @param SocialLogin $socialLogin
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, LoggerInterface $logger, SocialLogin $socialLogin)
    {
        $data = [];
        $errors = [];
        $code = 200;
        try {
            $reqContent = json_decode($request->getContent(), true);
            if (!empty($reqContent['accessToken']) && !empty($reqContent['authType'])) {
                $authType = filter_var($reqContent['authType'], FILTER_SANITIZE_STRING);
                $socialLogin->setAdapter($authType, $reqContent['accessToken']);
                $data = $socialLogin->login();
            }
            if (empty($reqContent['accessToken'])) {
                $errors[] = ['code' => 'token', 'message' => 'access token must be set'];
            }
            if (empty($reqContent['authType'])) {
                $errors[] = ['code' => 'auth_type', 'message' => 'auth type must be set'];
            }

        } catch (\Throwable $ex) {
            $logger->error($ex->getMessage());
            $errors[] = ['message' => $ex->getMessage()];
            $code = $ex->getCode() ?: 500;
        }
        return $this->resultJson($data, $code, $errors);
    }
}