<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\General\ThemeSettingRepository;

class ThemeSettingController extends Controller
{
    public function __construct(protected ThemeSettingRepository $themeSetting) {}


    /**
     * theme Option
     */
    public function index()
    {
        return view('portal::admin.setting-option.index');
    }

    public function backendSetting()
    {
        return view('portal::admin.backend-setting.index');
    }

    /**
     * Theme Setting
     *
     * @param  mixed  $request
     */
    public function themeSetting(Request $request)
    {
        try {
            if ($request->user()->can('themesetting.edit')) {
                return $this->themeSetting->updateOrCreate($request);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => $th->getMessage()]);
        }
    }

    /**
     * base64 image upload
     *
     * @param  mixed  $request
     * @return JsonResponse
     */
    public function imageUpload(Request $request)
    {

        try {
            $folder = isset($request->type) ? 'lms/certificates' : 'lms/theme-options';
            $result = $this->themeSetting->base64ImgUpload($request->image, $file = $request->old_file ? $request->old_file : '', folder: $folder);

            return response()->json(['status' => 'success', 'image_name' => $result['imageName'], 'path' => $result['path']]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false]);
        }
    }
}
