<?php
/**
 * Created by PhpStorm.
 * User: ssa41
 * Date: 2019-05-25
 * Time: 오후 5:35
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                "message" => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    public function respondUnauthenticated($message = "unauthenticated")
    {
        if($message == "unauthenticated")
            $message = __("response.".$message);

        return $this->setStatusCode(401)->respondWithError($message);
    }

    public function respondNotFound($message = "not found")
    {
        if($message == "not found")
            $message = __("response.".$message);

        return $this->setStatusCode(404)->respondWithError($message);
    }

    public function respondInternalError($message = "internal error")
    {
        if($message == "internal error")
            $message = __("response.".$message);

        return $this->setStatusCode(500)->respondWithError($message);
    }

    public function respondImproperCondition($message = "improper condition")
    {
        if($message == "improper condition")
            $message = __("response.".$message);

        return $this->setStatusCode(412)->respondWithError($message);
    }

    public function respondForbidden($message = "not allowed")
    {
        if($message == "not allowed")
            $message = __("response.".$message);

        return $this->setStatusCode(403)->respondWithError($message);
    }

    public function respondCreated($data = null, $message = "created")
    {
        if($message == "created")
            $message = __("response.".$message);

        return $this->setStatusCode(201)->respond([
            'data' => $data,
            'message' => $message
        ]);
    }

    public function respondUpdated($data = null, $message = "updated")
    {
        if($message == "updated")
            $message = __("response.".$message);

        return $this->respond([
            'data' => $data,
            'message' => $message
        ]);
    }

    public function respondDeleted($message = "deleted")
    {
        if($message == "deleted")
            $message = __("response.".$message);

        return $this->respond([
            "message" => $message
        ]);
    }

    public function respondSuccessfully($data = null, $message = "success")
    {
        if($message == "success")
            $message = __("response.".$message);

        return $this->respond([
            "data" => $data,
            "message" => $message
        ]);
    }

    protected function respondWithPagination($items, $data)
    {
        $data = array_merge($data, [
           'paginator' => [
               'total_count' => $items->total(),
               'total_page' => ceil($items->total() / $items->perPage()),
               'current_page' => $items->currentPage(),
               'limit' => $items->perPage()
           ]
        ]);

        return $this->respond($data);
    }
}
