@php
    $image =
        !empty($course->thumbnail) && fileExists('lms/courses/thumbnails', $course->thumbnail)
            ? asset('storage/lms/courses/thumbnails/' . $course->thumbnail)
            : asset('lms/frontend/assets/images/420x252.svg');

    $shortVideo =
        !empty($course->short_video) && fileExists('lms/courses/demo-videos', $course->short_video)
            ? asset('storage/lms/courses/demo-videos/' . $course->short_video)
            : null;

@endphp
@if ($course->video_src_type == 'local')
    <video id="course-demo" playsinline controls data-poster="{{ $image }}" data-course-id="{{ $course->id }}">>
        <source src="{{ $shortVideo }}" type="video/mp4" />
    </video>
@else
    <!-- VIMEO/YOUTUBE -->
    <div class="plyr__video-embed" id="course-demo">
        <iframe src="{{ $course->demo_url }}" allowfullscreen allowtransparency allow="autoplay" data-course-id="{{ $course->id }}">></iframe>
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const player = new Plyr('#course-demo');
        const courseId = videoElement.getAttribute('data-course-id');
        // Track play event
        player.on('play', () => {
            console.log('Video started playing');
            console.log(`Video started playing for course ID: ${courseId}`);
            // You can trigger your custom logic here
            // Example: send AJAX request, log to analytics, etc.
        });

        // Track pause event
        player.on('pause', () => {
            console.log(`Video paused for course ID: ${courseId}`);
            // Your custom logic for pause
        });

        // Optional: Track ended event
        player.on('ended', () => {
            console.log('Video ended');
        });
    });
</script>
