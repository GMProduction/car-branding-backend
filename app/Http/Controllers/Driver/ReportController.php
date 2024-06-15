<?php


namespace App\Http\Controllers\Driver;


use App\Helper\CustomController;

class ReportController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store()
    {
        try {

            return $this->jsonSuccessResponse('success');
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
