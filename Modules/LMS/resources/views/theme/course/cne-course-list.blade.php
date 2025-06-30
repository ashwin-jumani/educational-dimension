<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="CNE Activities" pageRoute="{{ route('course.cne') }}"
        pageName="Courses" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <input type="hidden" id="courseType">
            <div style="display:none">
             <x-theme::course.filter-sidebar />
            </div>
           
            <!-- START CONTENT -->
            <!-- <div class="col-span-full lg:col-span-8"> -->
                <div class="col-span-full lg:col-span-12">
                <div class="flex-center-between" style="display:none">
                    <h3 class="area-title text-xl">
                        {{ translate('Showing') }}
                        <span id="first-item">{{ $courses->firstItem() }}</span>
                        -
                        <span id="last-item">{{ $courses->lastItem() }}</span>
                        {{ translate('of') }}
                        <span id="total-item">{{ $courses->total() }}</span>
                        {{ translate('Results') }}
                    </h3>
                    <div class="flex-center gap-2" style="display: none;">
                        <button type="button" aria-label="Course layout grid" data-layout="grid"
                            class="card-layout-button btn-icon bg-primary-50 text-heading dark:text-white [&.active]:bg-primary [&.active]:text-white hidden md:flex active">
                            <i class="ri-layout-grid-line"></i>
                        </button>
                        <button type="button" aria-label="Course layout list" data-layout="list"
                            class="card-layout-button btn-icon bg-primary-50 text-heading dark:text-white [&.active]:bg-primary [&.active]:text-white hidden md:flex">
                            <i class="ri-list-check"></i>
                        </button>
                        <button type="button" aria-label="Off-canvas filter drawer" data-offcanvas-id="filter-drawer"
                            class="btn b-outline btn-secondary-outline lg:hidden">
                            <i class="ri-equalizer-line"></i>
                            {{ translate('Filter') }}
                        </button>
                    </div>
                </div>
                @php
    // Group courses by organization_id (null = 'other')
    $groupedCourses = $courses->groupBy(function ($course) {
        return $course->organization_id ?? 'other';
    });
@endphp

<div id="outputItemList" class="space-y-10">
    @foreach ($groupedCourses as $orgId => $group)
        <div class="col-span-full lg:col-span-12">
            <h3 class="area-title text-xl font-bold mb-4 text-primary" style="padding-top:20px">
                {{ $orgId === 'other' ? 'Other' : ($group->first()->organization?->userable?->name ?? 'No Organization') }}
            </h3>

            @if ($group->count())
                <div class="space-y-4">
                    @foreach ($group as $course)
                        <div class="bg-white p-4 rounded-lg shadow border area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                            <a href="{{ route('course.detail', $course->slug) }}" class="text-lg font-medium text-blue-600 hover:underline">
                                {{ $course->title }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500">{{ translate('No course found') }}</p>
            @endif
        </div>
    @endforeach
</div>

            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/frontend/assets/js/filter.js') }}"></script>
    @endpush
</x-frontend-layout>
