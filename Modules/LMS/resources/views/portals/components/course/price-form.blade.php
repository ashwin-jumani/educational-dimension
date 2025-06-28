<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="pricing">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <input type="hidden" name="price_id" id="pricingId" value="{{ $course?->coursePrice?->id ?? null }}">
        <div class="grid grid-cols-12 gap-4 card">
            <div class="col-span-full lg:col-span-6">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Course Pricing') }}</h6>
                <div class="mt-10">
                    <div class="leading-none mb-10">
                        <label for="price" class="form-label">
                            {{ translate('Course price') }} ($)
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <input type="number" id="price" name="price"
                            value="{{ $course?->coursePrice?->price ?? '' }}" class="form-input" required>
                        <span class="text-danger error-text price_err"></span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 peer/discount">
                            <input id="check-s-2" type="checkbox" name="discount_flag" class="check check-primary-solid"
                                {{ isset($course) && $course?->coursePrice?->discount_flag == 1 ? 'checked' : '' }}>
                            <label for="check-s-2" class="leading-none font-medium text-gray-500 dark:text-dark-text">
                                {{ translate('Check if this course has a discount') }}
                            </label>
                        </div>
                        <div class="hidden peer-has-[:checked]/discount:block pt-4">
                            <div class="leading-none">
                                <label for="discount" class="form-label">{{ translate('Discounted price') }}($)</label>
                                <input type="number" id="discount" name="discounted_price"
                                    placeholder="{{ translate('Discount') }}" class="form-input" required
                                    value="{{ $course?->coursePrice?->discounted_price ?? '' }}">
                                <div class="text-xs leading-none text-gray-500 dark:text-dark-text select-none mt-2">
                                    {{ translate('This course has') }}
                                    <span class="text-danger">
                                        {{ $course?->coursePrice?->discounted_price ?? '0' }}%
                                    </span>
                                    {{ translate('discount') }}
                                </div>
                                <span class="text-danger error-text discounted_price_err"></span>
                            </div>
                            <div class="leading-none mt-7" id="dicountPeriod">
                                <label for="discount" class="form-label">{{ translate('Discounted Period') }}</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group input-icon bg-[#F8F8F8] dark:bg-dark-icon !text-gray-900 !rounded-r-none">
                                        <i class="ri-calendar-line text-inherit"></i> </span>
                                    <input type="datetime-local" class="form-input !rounded-l-none" required
                                        name="discount_period"
                                        value="{{ $course?->coursePrice?->discount_period ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
