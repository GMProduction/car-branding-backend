<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\BroadcastReport;

class ReportController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {

            $query = BroadcastReport::with(['user.driver.car_type']);
            $dateStart = $this->field('date_start');
            $dateEnd = $this->field('date_end');
            if ($dateStart && $dateEnd) {
                $query->whereBetween('date', [$dateStart, $dateEnd]);
            }
            $data = $query->orderBy('created_at', 'DESC')
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
