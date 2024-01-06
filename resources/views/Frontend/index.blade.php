 @extends('Frontend.frontend_dashboard')
 @section('main')
 @section('title')
 Easy - Real Estate
 @endsection
 <!-- banner-section -->
@include('Frontend.Home.banner')

<!-- banner-section end -->


<!-- category-section -->
@include('Frontend.Home.category')

<!-- category-section end -->


<!-- feature-section -->


@include('Frontend.Home.feature')
<!-- feature-section end -->


<!-- video-section -->

@include('Frontend.Home.video')
<!-- video-section end -->


<!-- deals-section -->
@include('Frontend.Home.deals')

<!-- deals-section end -->


<!-- testimonial-section end -->

@include('Frontend.Home.testimonial')
<!-- testimonial-section end -->


<!-- chooseus-section -->
@include('Frontend.Home.chooseus')
<!-- chooseus-section end -->


<!-- place-section -->

@include('Frontend.Home.place')
<!-- place-section end -->


<!-- team-section -->
@include('Frontend.Home.team')

<!-- team-section end -->


<!-- cta-section -->
@include('Frontend.Home.cta')
<!-- cta-section end -->


<!-- news-section -->
@include('Frontend.Home.news')
<!-- news-section end -->


<!-- download-section -->
@include('Frontend.Home.download')
<!-- download-section end -->


@endsection
