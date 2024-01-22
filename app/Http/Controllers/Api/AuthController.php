<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ],[
            'email.required'=>'يرجي ادخال الايميل',
            'email.email' =>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'=> 'يجب أن تتكون كلمة المرور من ٦ أحرف على الأقل.'
        ]);
        if ($validator->fails()) {
            // return response()->json($validator->errors(), 422);
            return $this->apiResponse(null,$validator->errors(),400);
        }
        if (!$token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ],[
            'name.required' => 'يرجي ادخال الاسم',
            'name.between' => 'يجب أن يتراوح الاسم بين ٢ و١٠٠ حرف.',
            'email.required' => 'يرجي ادخال الايميل',
            'email.email' =>'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالحًا',
            'email.max' => 'يجب ألا يزيد طول البريد الإلكتروني عن ١٠٠ حرف.',
            'email.unique'=>'البريد الإلكتروني تم أخذه.',
            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min'=> 'يجب أن تتكون كلمة المرور من ٦ أحرف على الأقل.'
        ]);
        if ($validator->fails()) {
            // return response()->json($validator->errors()->toJson(), 400);
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            [
                'password' => bcrypt($request->password),
                'type' => $request->type,
            ]
        ));

        Library::createLibrary($user->id);
        // return response()->json([
        //     'message' => 'User successfully registered',
        //     'user' => $user
        // ], 201);
        return $this->apiResponse($user,'User successfully registered',201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => null,
            'user' => auth('api')->user()
        ]);
    }
}
