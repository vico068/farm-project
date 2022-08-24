<?php

namespace App\Infrastructure;

use Symfony\Component\HttpFoundation\Response;

trait ApiResponse
{

    public function prepareApiResponse($message = '', $data = null, $statusCode, $isSuccess = true)
    {
        if (!$message) $message = Response::$statusTexts[$statusCode];

        if ($isSuccess) {
            return response(['success' => true, 'data' => $data, 'message' => $message], $statusCode);
        } else {
            return response(['success' => false, 'message' => $message,], $statusCode);
        }
    }

    protected function success($message, $data = [], $statusCode = 200)
    {
        return $this->prepareApiResponse($message, $data, $statusCode, true);
    }

    protected function error($message, $statusCode = 422)
    {
        return $this->prepareApiResponse($message, null, $statusCode, false);
    }

    public function responseNotFound()
    {
        return $this->error('Not Found.', Response::HTTP_NOT_FOUND);
    }
}
