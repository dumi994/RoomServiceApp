@props(['site_data' => null])

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="utf-8">
    <title>Get Your Meal</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Aggiungi anche Bootstrap JS e Popper.js (necessari per il modal) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    <link rel="icon" href="{{ asset('images/icon.png') }}" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- CSS Files  CON asset() -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" type="text/css" id="bootstrap">
    <link rel="stylesheet" href="{{ asset('css/plugins.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/color.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" type="text/css">

    <!-- supersized  -->
    <link rel='stylesheet' href='{{ asset('js/supersized/css/supersized.css') }}' type='text/css'>
    <link rel='stylesheet' href='{{ asset('js/supersized/theme/supersized.shutter.css') }}' type='text/css'>

    <!-- color scheme  -->
    <link rel="stylesheet" href="{{ asset('css/colors/brown.css') }}" type="text/css" id="colors">

    <!-- CSS per icone google -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <!-- jQuery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>


</head>

<body class="has-menu-bar">

    <div id="content" class="no-bottom no-top">
        <div class="float-text">
            <div class="de_social-icons">
                {{--   <a href="https://it.lhw.com/hotel/LAndana-Resort-Castiglione-della-Pescaia-Italy">
                    <img style="width:16px; margin-bottom:5px" src="{{ asset('images/lhw-logo.png') }}" alt="">
                </a> --}}
                <a href="https://www.facebook.com/tenutalabadiola/?locale=it_IT"><i
                        class="fa fa-facebook fa-lg"></i></a>

                <a href="https://www.instagram.com/andana_resort/"><i class="fa fa-instagram fa-lg"></i></a>
            </div>

        </div>
        {{ $slot }}
    </div>

    <!-- Javascript Files  CON asset() -->
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/designesia.js') }}"></script>

    <!-- Supersized  -->
    <script src='{{ asset('js/supersized/js/supersized.3.2.7.js') }}'></script>
    <script src='{{ asset('js/supersized/theme/supersized.shutter.min.js') }}'></script>
    <style>
        /*    #prevslide,
        #nextslide,
        #pauseplay {
            display: none !important;
        } */
    </style>
    <script>
        var siteData = @json($site_data)

        jQuery(function($) {
            // Lista tutti gli elementi visibili (display non none e opacity > 0)
            /*   Array.from(document.querySelectorAll('*')).filter(el => {
                  const style = window.getComputedStyle(el);
                  return style.display !== 'none' && style.opacity !== '0';
              }).forEach(el => console.log(el, el.className)); */
            // Passo l'oggetto PHP a JS
            var slides = [];
            @php
                $homeImages = json_decode($site_data->home_bg_images ?? '[]', true);
            @endphp

            @foreach ($homeImages as $img)
                slides.push({
                    image: "{{ asset('storage/' . $img) }}",
                    title: "<div class='slider-text'><h2 class='wow fadeInUp'>" +
                        (siteData?.home_title || "Lorem Ipsum") +
                        "</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='/services'><span>" +
                        (siteData?.home_button || "Scopri di più") +
                        "</span></a></div>",
                    thumb: '',
                    url: ''
                });
            @endforeach
            
            @if (empty($homeImages))
                slides.push({
                    image: "{{ asset('images/background/1.jpg') }}",
                    title: "<div class='slider-text'><h2 class='wow fadeInUp'>" +
                        (siteData?.home_title || "Lorem Ipsum") +
                        "</h2><a class='btn-line wow fadeInUp' data-wow-delay='.3s' href='/services'><span>" +
                        (siteData?.home_button || "Scopri di più") +
                        "</span></a></div>",
                    thumb: '',
                    url: ''
                });
            @endif


            $.supersized({
                // Functionality
                slide_interval: 5000, // Length between transitions

                transition: 1, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                transition_speed: 500, // Speed of transition
                slide_links: false, // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                slides: slides,
                autoplay: 0,
                fit_always: 0,
                performance: 0,
                image_protect: 1 // Disables image dragging and right click with Javascript
            });

            jQuery("#pauseplay").toggle(
                function() {
                    jQuery(this).addClass("pause");
                },
                function() {
                    jQuery(this).removeClass("pause").addClass("play");
                });

            jQuery("#pauseplay").stop().fadeTo(150, .5);
            jQuery("#pauseplay").hover(
                function() {
                    jQuery(this).stop().fadeTo(150, 1);
                },
                function() {
                    jQuery(this).stop().fadeTo(150, .5);
                });

        });
    </script>

</body>

</html>
