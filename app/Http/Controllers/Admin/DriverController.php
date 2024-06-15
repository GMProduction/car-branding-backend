<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DriverController extends CustomController
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
            $data = Driver::with(['user', 'car_type'])
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function findByID($id)
    {
        try {
            $data = Driver::with(['user', 'car_type'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('driver not found');
            }
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function patchBroadcastStatus($id)
    {
        try {
            $data = Driver::with(['user', 'car_type'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('driver not found');
            }
            $status = $this->postField('status');
            $data->update([
                'on_broadcast' => $status
            ]);
            return $this->jsonSuccessResponse('success');
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }

    public function patchBroadcastName($id)
    {
        try {
            $data = Driver::with(['user', 'car_type'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonNotFoundResponse('driver not found');
            }
            $name = $this->postField('name');
            $data->update([
                'broadcast_name' => $name
            ]);
            return $this->jsonSuccessResponse('success');
        } catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
    private function store()
    {
        DB::beginTransaction();
        try {
            $email = $this->postField('email');
            $password = Hash::make($this->postField('password'));
            $role = 'driver';
            $carTypeID = $this->postField('car_type_id');
            $name = $this->postField('name');
            $vehicleID = $this->postField('vehicle_id');
            $phone = $this->postField('phone');
            $accountNumber = $this->postField('account_number');
            $bank = $this->postField('bank');

            $data_user = [
                'email' => $email,
                'password' => $password,
                'role' => $role
            ];
            $user = User::create($data_user);

            $data_driver = [
                'user_id' => $user->id,
                'car_type_id' => $carTypeID,
                'name' => $name,
                'vehicle_id' => $vehicleID,
                'phone' => $phone,
                'account_number' => $accountNumber,
                'bank' => $bank,
            ];
            Driver::create($data_driver);
            DB::commit();
            return $this->jsonSuccessResponse('success');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
