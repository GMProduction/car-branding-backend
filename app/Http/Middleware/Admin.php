<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Admin
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $payload = \auth()->payload();
        $role = $payload['role'];
        if ($role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden Access',
            ], 403);
        }
        return $next($request);
    }
}
