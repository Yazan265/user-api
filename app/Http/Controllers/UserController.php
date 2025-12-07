<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin')->except(['show', 'update']);
    }

    /**
     * عرض قائمة جميع المستخدمين
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * عرض نموذج إنشاء مستخدم جديد
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * حفظ المستخدم الجديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    /**
     * عرض بيانات مستخدم معين
     */
    public function show(User $user)
    {
        // التحقق من أن المستخدم يمكنه عرض بياناته فقط ما لم يكن مديراً
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $user->id) {
            abort(403, 'غير مصرح لك بعرض هذه البيانات');
        }

        return view('users.show', compact('user'));
    }

    /**
     * عرض نموذج تعديل مستخدم
     */
    public function edit(User $user)
    {
        // التحقق من أن المستخدم يمكنه تعديل بياناته فقط ما لم يكن مديراً
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $user->id) {
            abort(403, 'غير مصرح لك بتعديل هذه البيانات');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function update(Request $request, User $user)
    {
        // التحقق من أن المستخدم يمكنه تحديث بياناته فقط ما لم يكن مديراً
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $user->id) {
            abort(403, 'غير مصرح لك بتحديث هذه البيانات');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // تحديث كلمة المرور إذا تم إدخالها
        if ($request->filled('password')) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('users.show', $user)
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    /**
     * حذف المستخدم
     */
    public function destroy(User $user)
    {
        // منع حذف المستخدم نفسه
        if (Auth::user()->id === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'لا يمكنك حذف حسابك الشخصي');
        }

        $user->delete();
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('profile')
                    ->with('error', 'لا يمكن حذف حسابك لأنك المدير الوحيد للنظام');
            }
        }

        return redirect()->route('users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
