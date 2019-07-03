<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends AbstractController
{
    private $startDate;

    public function __construct()
    {
        $this->startDate = microtime(true);
    }

    protected function resultJson(?array $data, int $code = 200, array $errors=[], array $headers=[]): JsonResponse
    {
        $result['header'] = $this->resultHeader();
        $result['errors'] = $errors;
        $result['data'] = $data;

        return $this->json($result, $code, array_merge($headers, $this->defaultResponseHeaders()));
    }

    private function resultHeader()
    {
        $endDate = microtime(true);

        return [
            'time' => (float)number_format($endDate - $this->startDate, 4)
        ];
    }

    private function defaultResponseHeaders()
    {
        return [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS, PATCH',
            'Access-Control-Allow-Headers' => 'X-AUTH-TOKEN, Content-Type, Accept'
        ];
    }
}