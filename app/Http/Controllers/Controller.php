<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function json($data = [], $status = 200)
    {
        $d = is_string($data) ? ['message' => $data]  : $data;

        return response()->json($d, $status);
    }

    public function success($message = 'Success', $data = null)
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function fail($message = 'Whoops, something went wrong', $data = null, $status = 403)
    {
        return $this->json([
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}
