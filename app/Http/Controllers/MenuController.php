<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserModule;
use App\Http\Resources\MenuNodeResource;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // فرض می‌کنیم کاربر لاگین است (مثلاً آی‌دی 1)
        // در واقعیت: $userId = $request->user()->id;
        $userId = 1; 

        // 1. Fetching Data (Eager Loading is crucial here)
        // ما فقط ریشه‌ها (Root) را می‌گیریم، اما فرزندان و سیستم‌ماژول‌ها را Eager Load می‌کنیم
        $rootNodes = UserModule::query()
            ->where('user_id', $userId)
            ->whereNull('parent_id') // فقط آیتم‌های سطح اول
            ->with([
                'systemModule',                                    // برای گرفتن slug و name اصلی
                'children.systemModule',                           // برای گرفتن اطلاعات فرزندان
                'children.children.systemModule',                  // سطح سوم
                'children.children.children.systemModule',         // سطح چهارم
                'children.children.children.children.systemModule', // سطح پنجم (عمق بیشتر در صورت نیاز)
            ])
            ->orderBy('sort_order')
            ->get();

        // 2. Passing Data to Resource
        // اینجا جادو اتفاق می‌افتد. ما کالکشن مدل‌ها را به Resource می‌دهیم
        return MenuNodeResource::collection($rootNodes);
    }
}

