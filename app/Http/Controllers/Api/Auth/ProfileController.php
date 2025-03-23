<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'المستخدم غير مصدق عليه'], 401);
        }

        // التحقق من البيانات المدخلة
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $request->user()->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = $request->user();
        $user->fill($validator->validated());

        if ($request->has('email') && $user->isDirty('email')) {
            $user->email_verified_at = null; // إعادة تعيين تحقق البريد إذا تم تغييره
        }

        $user->save();

        return response()->json([
            'message' => 'تم تحديث الملف الشخصي بنجاح',
            'user' => $user
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
    // التحقق من صحة البيانات المدخلة
    $validator = Validator::make($request->all(), [
        'password' => ['required', 'string'],
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = $request->user();

    // التحقق من كلمة المرور يدويًا
    if (!Hash::check($request->password, $user->password)) {
        return response()->json(['errors' => ['password' => ['The password is incorrect.']]], 422);
    }

    // حذف جميع التوكنات للمستخدم
    $user->tokens()->delete();

    // حذف الحساب
    $user->delete();

    return response()->json([
        'message' => 'تم حذف الحساب بنجاح'
    ]);
    }
}
