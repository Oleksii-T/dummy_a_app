<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\Admin\SettingSiteRequest;
use App\Http\Requests\Admin\SettingPaymentRequest;

class SettingController extends Controller
{

    public function site(Request $request)
    {
        return view('admin.settings.site');
    }

    public function siteUpdate(SettingSiteRequest $request)
    {
        $data = $request->validated();
        return $this->update($data, route('admin.settings.site'));
    }

    public function payment(Request $request)
    {
        return view('admin.settings.payment');
    }

    public function paymentUpdate(SettingPaymentRequest $request)
    {
        $data = $request->validated();
        return $this->update($data, route('admin.settings.payment'));
    }

    private function update($data, $redirect)
    {
        try {
            foreach ($data as $key => $value) {
                Setting::set($key, $value);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Promocode updated successfully',
            'redirect' => $redirect
        ]);
    }
}