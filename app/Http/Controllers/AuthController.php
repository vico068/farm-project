<?php

namespace App\Http\Controllers;

use App\Infrastructure\ApiResponse;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    use ApiResponse;

    public function register(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'cnpj' => 'required|string|max:14|unique:tenants',
            'company_name' => 'required|unique:tenants,name',
        ]);

    if ($validator->fails()) {
            return $this->error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $plan = Plan::findOrFail($request->plan_id);

        $tenant = $plan->tenants()->create([
            'cnpj' => $request->cnpj,
            'name' => $request->company_name,
            "url" => Str::kebab($request->name),
            'email' => $request->email,
            'subscripton' => now(),
            'expires_at' => now()->addDays(7),
        ]);

        $user = $tenant->users()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = $user->createToken('meutoken')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => $user,
        ];

        return $this->success('Regitered', $response, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {

        $validator = \Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',

        ]);

    if ($validator->fails()) {
            return $this->error($validator->errors(), Response::HTTP_BAD_REQUEST);
        }


        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return $this->error('Unauthorized', Response::HTTP_UNAUTHORIZED);

        }

        $user = auth()->user();

        $token = $user->createToken('meutoken')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => $user,
        ];

        return response()->json($response);
    }

    function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }
}
