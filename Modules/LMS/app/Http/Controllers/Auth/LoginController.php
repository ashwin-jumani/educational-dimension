<?php

namespace Modules\LMS\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Modules\LMS\Emails\RegistrationMail;
use Modules\LMS\Models\User;
use Modules\LMS\Repositories\Auth\UserRepository;

class LoginController extends Controller
{
    public function __construct(protected UserRepository $user) {}

    /**
     * Display a listing of the resource.
     */
    public function showForm()
    {
        // Check if the user is authenticated
        if (Auth::check() || auth::guard('admin')->check()) {
            // Retrieve the user's guard type
            $guard = authCheck()->guard ?? null;
            // Determine the redirect route based on the guard type
            $redirectRoute = match ($guard) {
                'instructor' => 'instructor.dashboard', // Instructor dashboard
                'student' => 'student.dashboard',       // Student dashboard
                'organization' => 'organization.dashboard', // Organization dashboard
                default => 'admin.dashboard',                  // Default case (no route)
            };
            // Redirect to the matched route if available
            if ($redirectRoute) {
                return redirect()->route($redirectRoute);
            }
        }
        return view('theme::login.login');
    }

    /**
     * creating a new resource.
     */
    public function login(Request $request)
    {

        return $this->user->login($request);
    }

    /**
     *  resendMail
     *
     * @param  mixed  $request
     */
    public function resendMail(Request $request): JsonResponse
    {
        try {
            $user = User::with('userable')->firstWhere('email', $request->email);
            if (!$user) {
                return response()->json(['status' => 'error']);
            }
            $data = [
                'first_name' => $user?->userable?->first_name,
                'email' => $user->email,
                'id' => $user->id,
                'type' => 'resend',
            ];
            Mail::to($request->email)->queue(new RegistrationMail($data));

            return response()->json([
                'status' => 'success',
                'message' => translate('Mail Send Successfully.')
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error']);
        }
    }
}
