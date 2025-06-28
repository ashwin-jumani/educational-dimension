<?php

namespace Modules\LMS\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\LMS\Repositories\Purchase\PurchaseRepository;

class EnrollmentController extends Controller
{
    public function __construct(protected PurchaseRepository $purchase) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = $this->purchase->enrollments();
        return view('portal::admin.enrollment.index', compact('enrollments'));
    }

    public function create()
    {
        return view('portal::admin.enrollment.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function enrolled(Request $request)
    {
        // Check if the user has permission to edit the testimonial
        if (!has_permissions($request->user(), ['add.enrollment'])) {
            return json_error('You have no permission.');
        }

        // Attempt to update the testimonial
        $enrolled = $this->purchase->courseEnroll($request, $request->student_id);

        if ($enrolled['status'] !== 'success') {
            return response()->json($enrolled);
        }
        return $this->jsonSuccess('Enrolled Successfully!', route('enrollment.index'));
    }

    public function show($id)
    {
        $enrollment = $this->purchase->first($id);
        return view('portal::admin.enrollment.view', compact('enrollment'));
    }

    public function edit($id)
    {
        $enrollment = $this->purchase->first($id);
        return view('portal::admin.enrollment.create', compact('enrollment'));
    }

    public function destroy($id)
    {
        $enrollment = $this->purchase->delete($id);
        $enrollment['url'] = route('enrollment.index');
        return response()->json($enrollment);
    }
}
