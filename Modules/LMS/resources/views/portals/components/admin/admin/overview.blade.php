<div class="col-span-full 2xl:col-span-6 card">
    <div class="grid grid-cols-12 gap-4 h-full">
        <!-- Total Revenue Progress Card -->
        <!-- <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total revenue') }} 
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">

                        <div class="card-title text-2xl">
                            $<span class="counter-value" data-value="{{ $data['total_amount'] }}">{{ translate('0') }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->
        <!-- Total Enrollments Progress Card -->
        <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total enrollments') }} 
                </h6>

            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_enrolled'] }}">{{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Courses Progress Card -->
        <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total courses') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_courses'] }}">{{ translate('0') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Average rating Progress Card -->
        <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total instructors') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_instructor'] }}">{{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total organization') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_organization'] }}">{{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total students') }}
                </h6>

            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-8 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_student'] }}">{{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
