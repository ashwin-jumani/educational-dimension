<?php

namespace Modules\LMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Modules\LMS\Repositories\ThemeRepository;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(protected ThemeRepository $themeRepository) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $response = $this->themeRepository->getInstalledThemes();
        $themes = [];

        if ($response['success'] === true) {
            $themes = $response['themes'];
        }
        return view('portal::admin.theme.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function install(Request $request)
    {
        $response = $this->themeRepository->save($request->all());
        if ($response['status']  !== 'success') {
            // Setup error handling here.
            toastr()->error(translate("There are something went wrong when install theme."));
        }

        return redirect()->back();
    }

    public function activate(Request $request)
    {
        $id = $request->id;

        $response = $this->themeRepository->update($id, $request->all());

        if ($response['status']  !== 'success') {
            // Setup error handling here.
            toastr()->error(translate("There are something went wrong when activate theme."));
        }

        $theme = $response['data'] ?? null;

        if ($theme && is_object($theme)) {
            session()->put('active_theme', $theme);
        }
        return redirect()->back();
    }

    public function activationByUrl($slug, $uuid, Request $request)
    {
        $response = $this->themeRepository->search([
            'slug' => $slug,
            'uuid' => $uuid,
        ]);

        if ($response['status'] !== 'success') {
            toastr()->error(translate("No Home found."));
            return redirect()->back();
        }

        $theme = $response['data'][0] ?? null;

        if (! $theme) {
            toastr()->error(translate("No Home found."));
            return redirect()->back();
        }

        // $response = $this->themeRepository->all();

        // $themes = $response['data'] ?? [];

        // if (empty($themes)) {
        //     toastr()->error(translate("No Home found."));
        //     return redirect()->back();
        // }

        // foreach ($themes as $oldTheme) {
        //     if ($oldTheme->id === $theme->id) {
        //         continue;
        //     }

        //     $oldTheme->active = 0;
        //     $oldTheme->save();
        // }

        // $theme->active = 1;
        // $theme->save();

        // if ($theme) {
        //     session()->put('active_theme', $theme);
        // }

        // toastr()->success("{$theme->name} " . translate('has been changed successfully'));

        session()->put('active_theme', $theme);
        
        return redirect()->route('home.index');
    }
}
