@php
    $logo = get_theme_option(key: 'theme_logo') ?? [];
    $defaultLogo =
        isset($logo['logo']) && fileExists('lms/theme-options', $logo['logo']) == true
            ? asset("storage/lms/theme-options/{$logo['logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $footerLogo =
        isset($logo['footer_logo']) && fileExists('lms/theme-options', $logo['footer_logo']) == true
            ? asset("storage/lms/theme-options/{$logo['footer_logo']}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');

    $favIcon =
        isset($logo['favicon']) && fileExists('lms/theme-options', $logo['favicon']) == true
            ? asset("storage/lms/theme-options/{$logo['favicon']}")
            : asset('lms/frontend/assets/images/favicon.ico');

    $data = array_merge($data, [
        'default_logo' => $defaultLogo,
        'footer_logo' => $footerLogo,
        'fav_icon' => $favIcon,
        'menus' => get_menus(),
    ]);
@endphp

<x-frontend-layout :data="$data">
    <!-- START BANNER AREA -->
    <x-theme::hero.hero-one />
    <!-- END BANNER AREA -->
    <!-- START CATEGORY AREA -->
    <x-theme::category.top-category :categories="$data['categories']" />
    <!-- END CATEGORY AREA -->

    <!-- START POPULAR COURSE AREA -->
    <x-theme::course.top-course :courses="$data['courses']" />
    <!-- END POPULAR COURSE AREA -->

    <!-- START TESTIMONIAL AREA -->
    <x-theme::testimonial.testimonial-one :testimonials="$data['testimonials']" />
    <!-- END TESTIMONIAL AREA -->

    <!-- START COUNTER AREA -->
    <x-theme::counter.counter-one />
    <!-- END COUNTER AREA -->

    <!-- START UPCOMING COURSE AREA -->
    <x-theme::course.upcoming-course :upcomingCourses="$data['upcoming_courses']" />
    <!-- END UPCOMING COURSE AREA -->

    <!-- START INSTRUCTOR AREA -->
    <x-theme::instructor.top-instructor :instructors="$data['instructors']" />
    <!-- END INSTRUCTOR AREA -->

    <!-- START ONLINE VIDEO COURSE AREA -->
    <x-theme::join-us.join-us />
    <!-- END ONLINE VIDEO COURSE AREA -->

    <x-theme::blog.latest-blog-one :blogs="$data['blogs']" />

</x-frontend-layout>
