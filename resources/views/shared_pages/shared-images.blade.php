<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $comment ?? 'COmment' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Magnific Popup core CSS file -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style>
        .container.share .comment {
            font-size: 30pt;
        }
        .container.share {
            font-size: 20pt;
        }
        .mfp-image-holder .mfp-close, .mfp-iframe-holder .mfp-close {
            width: 70px;
            height: 70px;
            font-size: 80px;
        }
        .mfp-arrow:after {
            border-top-width: 26px;
            border-bottom-width: 26px;
            top: 16px;
        }
        .mfp-arrow-left:after {
            border-right: 32px solid #FFF;
            margin-left: 33px;
        }
        .mfp-arrow-right:after {
            border-left: 32px solid #FFF;
            margin-left: 28px;
        }
        .mfp-arrow:after {
            border-top-width: 26px;
            border-bottom-width: 26px;
            top: 16px;
        }
        .share-note.blue {
            color: #007bff;
        }
        .share-note {
            color: #ff9900;
        }
        .fix-img {
            height: 350px;
            object-fit: cover;
            width: 100% !important;
            display: block;
        }
        .img-a {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 100%;
        }
        section {
            padding: 10px 10px;
        }
        .container{
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            }
            #map,
            #pano {
            float: left;
            height: 230px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger d-flex justify-content-center" style="font-size: 12px;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('add.property') }}">
                <img src="{{ asset('assets/logos/spms-nav-logo.png') }}" class="img-fluid" width="60" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
            </div>
        </div>
    </nav>

    <section jstcache="0">
        <div class="container share" jstcache="0">
            <div class="row">
                <div class="col-12 comment">{{ $comment ?? '' }}</div>
            </div>
            {{-- @if ($typeUrl == 'URL Open') --}}
            <div class="row">
                <div class="col-12 share">
                    <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=63bdadcf457e4b001b975c5c&product=inline-share-buttons&source=platform" async="async"></script>
                    <div class="sharethis-inline-share-buttons"></div>
                </div> 
            {{-- @endif --}}
            <div class="popup-gallery" jstcache="0">
                <div class="row" style="border: 4px solid blue; border-top: 0" jstcache="0">
                    @foreach ($properties as $property)
                        @php
                            $options = json_decode($propertyOptions, true) ?? [];
                            // dd($options);
                        @endphp
                        @if(in_array('show_building_name', $options ?? []))
                            <br><br>
                            <div style="border-top: 4px solid blue" class="col-12 mb-3">
                                <h2 style="color:blue;">{{ $property->building }}</h2>
                            </div>
                            <br>
                        @endif
                        
                        @if(in_array('show_map', $options))
                            <input hidden="" id="building_address" value="{{ $property->street }}">
                            <div class="col-12 col-md-6 mb-4">
                                <div id="map"></div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div id="pano"></div>
                            </div>
                        @endif
                        @php
                            $individual_comments = json_decode($individualComments, true);
                            $valuesToCheck = ['building', 'street', 'district', 'floor', 'flat', 'block', 'rental_price', 'rental_g', 'rental_n', 'selling_price', 'selling_g', 'selling_n', 'gross_sf', 'net_sf', 'mgmf', 'rate', 'land', 'oths', 'youtube_link']; 
                        @endphp
                        @if($individual_comments[$property->code] ?? '')
                            @if(in_array('show_as_list', $options))
                                @if(isset($individual_comments[$property->code]))
                                    <h4 class="w-100" style="font-size: 37px; color: red; font-weight: 700;">
                                        {!! implode('<br>', array_map('trim', explode(',', $individual_comments[$property->code]))) !!}
                                    </h4>
                                @endif
                            @else
                                <h4 class="w-100" style="font-size: 37px; color: red; font-weight: 700;">{{ $individual_comments[$property->code] ?? '' }}</h4>
                            @endif
                        @endif
                        @if(count(array_intersect($valuesToCheck, $options)))
                            <div class="accordion" id="accordion_{{ $property->building_id }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading_{{ $property->building_id }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                            data-bs-target="#collapse_{{ $property->building_id }}" 
                                            aria-expanded="true" aria-controls="collapse_{{ $property->building_id }}">
                                            <span class="d-flex justify-content-between w-100">
                                                <span>樓盤詳情</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M12 5l0 14"></path>
                                                    <path d="M5 12l14 0"></path>
                                                </svg>
                                            </span>
                                        </button>
                                    </h2>
                                    <div id="collapse_{{ $property->building_id }}" 
                                        class="accordion-collapse collapse show" 
                                        aria-labelledby="heading_{{ $property->building_id }}" 
                                        data-bs-parent="#accordion_{{ $property->building_id }}">
                                        <div class="accordion-body">
                                            @if(in_array('building', $options))
                                                <span style="font-size: 25px">大廈: <span style="color: blue">{{ $property->building }}</span></span><br>
                                            @endif
                                            @if(in_array('street', $options))
                                                <span style="font-size: 25px">街道: <span style="color: blue">{{ $property->street }}</span></span><br>
                                            @endif
                                            @if(in_array('district', $options))
                                                <span style="font-size: 25px">地區: <span style="color: blue">{{ $property->district }}</span></span><br>
                                            @endif
                                            @if(in_array('floor', $options))
                                                <span style="font-size: 25px">樓層: <span style="color: blue">{{ $property->floor }}</span></span><br>
                                            @endif
                                            @if(in_array('flat', $options))
                                                <span style="font-size: 25px">單位: <span style="color: blue">{{ $property->flat }}</span></span><br>
                                            @endif
                                            @if(in_array('block', $options))
                                                <span style="font-size: 25px">座數: <span style="color: blue">{{ $property->block }}</span></span><br>
                                            @endif
                                            @if(in_array('rental_price', $options))
                                                <span style="font-size: 25px">業主叫租: <span style="color: blue">{{ $property->rental_price }}</span></span><br>
                                            @endif
                                            @if(in_array('rental_g', $options))
                                                <span style="font-size: 25px">呎租(建): <span style="color: blue">{{ $property->rental_g }}</span></span><br>
                                            @endif
                                            @if(in_array('rental_n', $options))
                                                <span style="font-size: 25px">呎租(實): <span style="color: blue">{{ $property->rental_n }}</span></span><br>
                                            @endif
                                            @if(in_array('selling_price', $options))
                                                <span style="font-size: 25px">售價: <span style="color: blue">{{ $property->selling_price }}</span></span><br>
                                            @endif
                                            @if(in_array('selling_g', $options))
                                                <span style="font-size: 25px">呎價(建): <span style="color: blue">{{ $property->selling_g }}</span></span><br>
                                            @endif
                                            @if(in_array('selling_n', $options))
                                                <span style="font-size: 25px">呎價(實): <span style="color: blue">{{ $property->selling_n }}</span></span><br>
                                            @endif
                                            @if(in_array('gross_sf', $options))
                                                <span style="font-size: 25px">建築面積: <span style="color: blue">{{ $property->gross_sf }}</span></span><br>
                                            @endif
                                            @if(in_array('net_sf', $options))
                                                <span style="font-size: 25px">實用面積: <span style="color: blue">{{ $property->net_sf }}</span></span><br>
                                            @endif
                                            @if(in_array('mgmf', $options))
                                                <span style="font-size: 25px">管理費: <span style="color: blue">{{ $property->mgmf }}</span></span><br>
                                            @endif
                                            @if(in_array('rate', $options))
                                                <span style="font-size: 25px">差餉: <span style="color: blue">{{ $property->rate }}</span></span><br>
                                            @endif
                                            @if(in_array('land', $options))
                                                <span style="font-size: 25px">地租: <span style="color: blue">{{ $property->land }}</span></span><br>
                                            @endif
                                            @if(in_array('oths', $options))
                                                <span style="font-size: 25px">其他: <span style="color: blue">{{ $property->oths }}</span></span><br>
                                            @endif
                                            @if(in_array('youtube_link', $options))
                                                <hr>
                                                <h1>lobby clip:</h1>
                                                <iframe class="youtubeIframe" data-url="{{ $property->yt_link_1 }}" frameborder="0" style="width: 100%;height: 205px" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                                <hr>
                                                <hr>
                                                <h1>L2:</h1>
                                                <iframe class="youtubeIframe" data-url="{{ $property->yt_link_2 }}" frameborder="0" style="width: 100%;height: 205px" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                                <hr>
                                            @endif
                                            @if(in_array('cargo_lift', $options))
                                                <span style="font-size: 25px">載貨電梯: <span style="color: blue">{{ $property->cargo_lift }}</span></span><br>
                                            @endif
                                            @if(in_array('customer_lift', $options))
                                                <span style="font-size: 25px">載客電梯: <span style="color: blue">{{ $property->customer_lift }}</span></span><br>
                                            @endif
                                            @if(in_array('num_floors', $options))
                                                <span style="font-size: 25px">最高樓層: <span style="color: blue">{{ $property->num_floors }}</span></span><br>
                                            @endif
                                            @if(in_array('car_park', $options))
                                                <span style="font-size: 25px">停車場: <span style="color: blue">{{ $property->car_park }}</span></span><br>
                                            @endif
                                            @if(in_array('ceiling_height', $options))
                                                <span style="font-size: 25px">樓層高度: <span style="color: blue">{{ $property->ceiling_height }}</span></span><br>
                                            @endif
                                            @if(in_array('air_con_system', $options))
                                                <span style="font-size: 25px">冷氣系統: <span style="color: blue">{{ $property->air_con_system }}</span></span><br>
                                            @endif
                                            @if(in_array('building_loading', $options))
                                                <span style="font-size: 25px">樓面承重: <span style="color: blue">{{ $property->building_loading }}</span></span><br>
                                            @endif
                                            {{-- <span style="font-size: 25px">enter_password: <span style="color: blue">{{ $property->enter_password }}</span></span><br>
                                            <span style="font-size: 25px">Others: <span style="color: blue"></span></span><br>
                                            @php
                                                $others = json_decode($property->others, true);
                                                $dates = json_decode($property->other_date, true);
                                                $formats = json_decode($property->other_free_formate, true);
                                            @endphp
                                            @if (!empty($others) && is_array($others))
                                                @foreach ($others as $index => $other)
                                                    <span style="font-size: 18px">{{ $other ?? 'N/A' }}<span style="color: green">({{ $dates[$index] ?? 'N/A' }}) {{ $formats[$index] ?? 'N/A' }}</span></span><br>
                                                @endforeach
                                            @endif
                                            <span style="font-size: 25px">decorations: <span style="color: blue">{{ $property->decorations }}</span></span><br>
                                            <span style="font-size: 25px">facilities: <span style="color: blue">{{ $property->facilities }}</span></span><br>
                                            <span style="font-size: 25px">types: <span style="color: blue">{{ $property->types }}</span></span><br>
                                            <span style="font-size: 25px">code: <span style="color: blue">{{ $property->code }}</span></span><br> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @foreach ($property->photos  as $images)
                            @php
                                $imgsOptions = is_array($imgsOptions) ? $imgsOptions : json_decode($imgsOptions, true);
                                $imageDetails = isset($imgsOptions[$images->id]) ? $imgsOptions[$images->id] : null;
                            @endphp
                            <div class="col-4 mt-3 mb-3">
                                <a id="{{ $images->id }}" class="img-a" href="{{ asset($images->original_image) }}" title="">
                                    <img class="img-fluid fix-img shadow" src="{{ asset($images->square_image) }}" alt="" title="{{ $imageDetails['note'] ?? '' }}">
                                </a>
                                @if ($imageDetails['note'] ?? '' || $imageDetails['room'] == 1 || $imageDetails['size'] == 1 || $imageDetails['price'] == 1)
                                    <div class="share-note blue">{{ $imageDetails['note'] ?? '' }}</div>
                                    <div class="share-note">單位: {{ ($imageDetails['room'] == 1) ? $images->room_number : '' }}</div>
                                    <div class="share-note">呎吋: {{ ($imageDetails['size'] == 1) ? $images->size : '' }}</div>
                                    <div class="share-note">價錢: {{ ($imageDetails['price'] == 1) ? $images->price : '' }}</div>
                                @endif
                            </div>
                        @endforeach                      
                    @endforeach
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p>“我們會為您精準搜尋最優質的盤源，並能在具有潛力的物業流出市場前推薦給您，歡迎聯絡我們視察物業！” 保誠物業。</p>
                    <p>物業的呎吋、價格或因應提供方之準確性及市場變化而有所不同，一切需以最終確認為準。</p>
                </div>
            </div>
        </div>
    </section>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Magnific Popup core JS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.popup-gallery').each(function() { 
                $(this).magnificPopup({
                    delegate: 'a', 
                    type: 'image',
                    gallery: {
                    enabled:true,
                    preload: [0,2], 
                    navigateByImgClick: true,

                    arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',

                    tPrev: 'Previous (Left arrow key)', 
                    tNext: 'Next (Right arrow key)',
                    tCounter: '<span class="mfp-counter">%curr% of %total%</span>'
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.youtubeIframe').each(function () {
                let youtubeUrl = $(this).data('url');
                let embedUrl = '';
                let newHeight = '205px';

                if (youtubeUrl.includes('/shorts/')) {
                    let shortsId = youtubeUrl.split('/shorts/')[1].split('?')[0];
                    embedUrl = "https://www.youtube.com/embed/" + shortsId;
                    newHeight = '660px';  // Adjust for YouTube Shorts
                } else if (youtubeUrl.includes('?v=')) {
                    let videoId = youtubeUrl.split('?v=')[1].split('&')[0];
                    embedUrl = "https://www.youtube.com/embed/" + videoId;
                } else {
                    let urlParts = youtubeUrl.split('/');
                    let videoId = urlParts[urlParts.length - 1].split('?')[0];
                    embedUrl = "https://www.youtube.com/embed/" + videoId;
                }

                if (embedUrl.startsWith("https://www.youtube.com/embed/")) {
                    $(this).attr('src', embedUrl).css('height', newHeight);
                } else {
                    console.error("Invalid Embed URL:", embedUrl);
                }
            });
        });
        
        // google map 
        let lat = '';
        let lng = '';
        let loc = '';

        var map;
        var panorama;

        function processSVData(data, status) {
            if (status === google.maps.StreetViewStatus.OK) {
                let panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'));
                panorama.setPano(data.location.pano);
                panorama.setPov({ heading: 270, pitch: 0 });
                panorama.setVisible(true);
            } else {
                console.error("Street View data not found for this location.");
            }
        }

        function initialize() {
            let address = document.getElementById('building_address').value;
            let geocoder = new google.maps.Geocoder();

            geocoder.geocode({ address: address }, function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    let lat = results[0].geometry.location.lat();
                    let lng = results[0].geometry.location.lng();
                    let mylatlng = new google.maps.LatLng(lat, lng);
                    let sv = new google.maps.StreetViewService();

                    let map = new google.maps.Map(document.getElementById('map'), {
                        center: mylatlng,
                        zoom: 16
                    });

                    sv.getPanorama({ location: mylatlng, radius: 50 }, processSVData);

                    map.addListener('click', function (event) {
                        sv.getPanorama({ location: event.latLng, radius: 50 }, processSVData);
                    });

                    console.log("Latitude:", lat, "Longitude:", lng);
                }
            });
        }

        window.initialize = initialize;
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACk1RzpwGH2o8goef4pgIP8C1-_BNDCD0&callback=initialize&v=weekly"></script>
</body>
</html>