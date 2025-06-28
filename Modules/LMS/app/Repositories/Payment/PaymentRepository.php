<?php

namespace Modules\LMS\Repositories\Payment;

use Modules\LMS\Classes\Cart;
use Modules\LMS\Enums\PurchaseType;
use Modules\LMS\Models\Courses\Bundle\CourseBundle;
use Modules\LMS\Models\Courses\Course;
use Modules\LMS\Models\PaymentMethod;
use Modules\LMS\Models\Purchase\Purchase;
use Modules\LMS\Models\Purchase\PurchaseDetails;

abstract class PaymentRepository
{
    protected $gateway;

    protected $methodName;

    /**
     * makePayment
     *
     * @param  array  $array
     */
    abstract public function makePayment($array);

    /**
     * send
     *
     * @param  array  $array
     */
    public function send($array)
    {
        try {
            $response = $this->gateway->purchase($array)->send();
            if ($response->isRedirect()) {
                $response->redirect();
            
            } elseif ($response->isSuccessful()) {
                $this->purchaseCourses();

                return [
                    'status' => 'success',
                    'url' => route('transaction.success'),

                ];
            } else {
                return $response->getMessage();
            }
        } catch (\Throwable $th) {
            return [
                'status' => 'error',
                'message' => $th->getMessage(),
            ];
        }
    }

    /**
     * purchaseCourses
     *
     * @return void
     */
    public function purchaseCourses()
    {
        $cart = Cart::get();
        if (! empty($cart['courses'])) {
            $purchase = Purchase::create(
                [
                    'total_amount' => Cart::totalPrice(),
                    'payment_method' => $this->methodName,
                    'user_id' => authCheck()->id,
                    'type' => 'purchase',
                    'status' => 'success',
                ]
            );
            foreach ($cart['courses'] as $cart) {
                $courseInfo = '';
                if ($cart['type'] == 'bundle') {
                    $courseInfo = CourseBundle::firstWhere('id', $cart['id']);
                } else {
                    $courseInfo = Course::with('coursePrice')->firstWhere('id', $cart['id']);
                }
                PurchaseDetails::create(
                    attributes: [
                        'purchase_number' => strtoupper(orderNumber()),
                        'purchase_id' => $purchase->id,
                        'user_id' => authCheck()->id,
                        'course_id' => $cart['type'] == 'course' ? $courseInfo->id : null,
                        'bundle_id' => $cart['type'] == 'bundle' ? $courseInfo->id : null,
                        'price' => $courseInfo?->coursePrice ? $courseInfo->coursePrice->price : $courseInfo->price,
                        'details' => $courseInfo,
                        'type' => PurchaseType::PURCHASE,
                        'purchase_type' => $cart['type'] == 'bundle' ? PurchaseType::BUNDLE : PurchaseType::COURSE,
                    ]
                );
            }
        }
        Cart::clear();
    }

    /**
     * geMethodInfo
     *
     * @param string
     * @return object
     */
    public function geMethodInfo()
    {
        return PaymentMethod::where('method_name', $this->methodName)->first();
    }
}
