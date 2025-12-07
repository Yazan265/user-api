<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->mixedCase()->numbers()
            ],
            'role' => 'in:admin,user'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? "user",
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered',
            'user' => $user
        ], 201);
    }

    public function index()
    {
        return response()->json(User::all());
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) return response()->json(['error' => 'Not Found'], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|between:2,100',
            'email' => 'string|email|max:100|unique:users,email,' . $id,
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $user->update($validator->validated());

        return response()->json([
            'message' => 'User updated',
            'user' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) return response()->json(['error' => 'Not Found'], 404);

        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }

    //  إرجاع التوكن
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => Auth::guard('api')->user()
        ]);
    }
}
