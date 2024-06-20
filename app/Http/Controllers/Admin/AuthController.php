<?php


namespace App\Http\Controllers\Admin;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sign_in()
    {
        try {
            $email = $this->postField('email');
            $password = $this->postField('password');
            $user = User::with(['admin'])
                ->where('email', '=', $email)
                ->where('role', '!=', 'driver')
                ->first();
            if (!$user) {
                return $this->jsonNotFoundResponse('user account not found!');
            }
            $is_password_valid = Hash::check($password, $user->password);
            if (!$is_password_valid) {
                return $this->jsonBadRequestResponse('password did not match');
            }

            $name = $user->admin->name;
            $customClaims = [
                'email' => $user->email,
                'name' => $name
            ];
            $access_token = $this->generateTokenById($user->id, 'admin', $customClaims);
            return $this->jsonSuccessResponse('success', [
                'access_token' => $access_token,
                'token_type' => 'bearer'
            ]);
        }catch (\Throwable $e) {
            return $this->jsonErrorResponse($e->getMessage());
        }
    }
}
