<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\CarType;

class CarTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            return $this->store();
        }
        try {
            $data = CarType::with([])
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function findByID($id)
    {
        try {
            $data = CarType::with([])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('item not found');
            }
            return $this->jsonSuccessResponse('success', $data);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    private function store()
    {
        try {
            $name = $this->postField('name');
            $data_request = [
                'name' => $name
            ];
            CarType::create($data_request);
            return $this->jsonSuccessResponse('success');
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
