<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->with('error', 'كلمة المرور الحالية غير صحيحة');
        }

        // تحديث كلمة المرور
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return redirect()->route('profile')
            ->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
    public function destroy(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // التحقق إذا كان المستخدم هو المدير الوحيد
    if ($user->role === 'admin') {
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('profile')
                ->with('error', 'لا يمكن حذف حسابك لأنك المدير الوحيد للنظام');
        }
    }

    try {
        // تسجيل اسم المستخدم قبل الحذف (للعرض في رسالة النجاح)
        $userName = $user->name;

        // تسجيل الخروج أولاً
        Auth::logout();

        // حذف المستخدم
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('info', "تم حذف حساب $userName بنجاح. نأسف لرحيلك!");

    } catch (\Exception $e) {
        // إعادة تسجيل الدخول في حالة فشل الحذف
        Auth::loginUsingId($user->id);

        return redirect()->route('profile')
            ->with('error', 'حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
    }
}
}
