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
            $page = (int) $this->field('page');
            $perPage = (int) $this->field('per_page');
            $offset = ($page - 1) * $perPage;

            if ($dateStart && $dateEnd) {
                $query->whereBetween('date', [$dateStart, $dateEnd]);
            }
            $total_rows = $query->count();
            $total_page = ceil($total_rows / (int) $perPage);
            $data = $query
                ->offset($offset)
                ->limit($perPage)
                ->orderBy('created_at', 'DESC')
                ->get();

            $meta = [
                'total_rows' => $total_rows,
                'total_page' => $total_page,
                'page' => (int) $page,
                'per_page' => (int) $perPage
            ];
            return $this->jsonSuccessResponse('success', $data, $meta);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
