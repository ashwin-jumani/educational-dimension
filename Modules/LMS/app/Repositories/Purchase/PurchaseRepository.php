<?php

namespace Modules\LMS\Repositories\Purchase;

use Illuminate\Support\Facades\Validator;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\Purchase\Purchase;
use Modules\LMS\Models\Purchase\PurchaseDetails;

class PurchaseRepository
{
    protected static $model = PurchaseDetails::class;

    protected static $purchase = Purchase::class;

    protected static $rules = [
        'save' => [
            'student_id' => 'required',
            'courses' => 'required',
        ],

    ];

    /**
     *  courseEnroll
     *
     * @param  mixed  request
     * @param int  userId
     */
    public function courseEnroll($request, $userId): array
    {
        $validator = Validator::make($request->all(), static::$rules['save']);
        if ($validator->fails()) {
            return [
                'status' => 'error',
                'data' => $validator->errors()->toArray(),
            ];
        }
        $status = false;
        $data = [
            'user_id' => $userId,
            'type' => PurchaseType::ENROLLED,
            'status' => 'success',
        ];

        if (isAdmin() && !empty($request->id)) {
            $enrolled = $this->first($request->id);
            $enrolled->delete();
        }
        $purchase = $this->purchaseStore($data);
        foreach ($request->courses as $courseId) {
            if (! static::$model::where(['user_id' => $userId, 'course_id' => $courseId])->exists()) {
                $status = true;
                $course = $this->courseGetById($courseId);
                if ($course) {
                    static::$model::updateOrCreate(
                        [
                            'purchase_number' => strtoupper(orderNumber()),
                            'user_id' => $userId,
                            'course_id' => $courseId,
                            'details' => $course,
                            'type' => PurchaseType::ENROLLED,
                            'purchase_type' => PurchaseType::COURSE,
                            'purchase_id' => $purchase->id,
                        ]
                    );
                }
            }
        }

        if ($status == false) {
            static::$purchase::latest()->delete();
        }

        return [
            'status' => 'success',
        ];
    }

    /**
     *  courseEnroll
     *
     * @param  mixed  request
     * @param  int  userId
     */
    public function courseGetById($id)
    {
        return Course::with('coursePrice')
            ->firstWhere('id', $id);
    }

    /**
     *  courseEnroll
     *
     * @param  int  $item
     */
    public function enrollments($item = 10)
    {
        return static::$model::with('user.userable.translations', 'course.instructors.userable.translations', 'courseBundle.instructor',  'courseBundle.organization')
            ->latest()
            ->where('type', PurchaseType::ENROLLED)
            ->paginate($item);
    }
    /**
     * courseEnrolled
     *
     * @param  mixed  $request
     */
    public function courseEnrolled($request)
    {

        try {
            if (is_free($request->id, type: $request->type ?? null)) {
                $userId = authCheck()->id;
                $type = $request->type ?? 'course';

                // Prepare data for purchase record.
                $purchaseData = [
                    'user_id' => $userId,
                    'type' => PurchaseType::ENROLLED,
                    'status' => 'success',
                ];

                $purchase = $this->purchaseStore($purchaseData);

                // Retrieve course or bundle information based on the request type.
                $courseInfo = $type === 'bundle'
                    ? CourseBundle::findOrFail($request->id)
                    : Course::with('coursePrice')->findOrFail($request->id);

                // Create a new record in the model with appropriate fields set.
                static::$model::create([
                    'purchase_number' => strtoupper(orderNumber()),
                    'purchase_id' => $purchase->id,
                    'user_id' => $userId,
                    'course_id' => $type === 'course' ? $courseInfo->id : null,
                    'bundle_id' => $type === 'bundle' ? $courseInfo->id : null,
                    'details' => $courseInfo,
                    'type' => PurchaseType::ENROLLED,
                    'purchase_type' => $type === 'bundle' ? PurchaseType::BUNDLE : PurchaseType::COURSE,
                ]);

                return [
                    'status' => 'success'
                ];
            }
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     *  courseEnroll
     *
     * @param  int  $item
     */
    public function first($id)
    {
        return static::$model::with('user.userable', 'course.instructors.userable', 'courseBundle.instructor.userable', 'courseBundle.organization.userable')
            ->latest()
            ->where('type', PurchaseType::ENROLLED)
            ->where('id', $id)
            ->first();
    }

    /**
     *  purchaseStore
     * @param array $data 
     */
    public function purchaseStore($data)
    {
        $purchase = static::$purchase::create($data);

        return $purchase;
    }


    public function delete($id)
    {
        $purchase = $this->first($id);
        if ($purchase->delete()) {
            return [
                'status' => 'success'
            ];
        }
        return [
            'status' => 'error'
        ];
    }
    /**
     *  getByUserId
     * @param array $data 
     */
    public static function getByUserId($data)
    {
        if (bundle_course_check($data['course_id']) ||  static::$model::where($data)->first()) {
            return true;
        }
        return false;
    }
}
