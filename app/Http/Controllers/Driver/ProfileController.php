<?php


namespace App\Http\Controllers\Driver;


use App\Helper\CustomController;
use App\Models\Driver;

class ProfileController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Driver::with(['user', 'car_type'])
                ->where('user_id', '=', auth()->id())
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('profile not found...');
            }

            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
