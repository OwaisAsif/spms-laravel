<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Property Images</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- Magnific Popup core CSS file -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style>
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
    </style>
</head>
<body class="bg-light">
    {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-danger d-flex justify-content-center" style="font-size: 12px;">
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
    </nav> --}}

    <section jstcache="0">
        <div class="container share" jstcache="0">
            <div class="popup-gallery" jstcache="0">
                <div class="row" style="border: 4px solid blue;" jstcache="0">
                    @if ($property->photos->count() > 0)
                        @foreach ($property->photos  as $images)
                            <div class="col-4 mt-3 mb-3">
                                <a id="{{ $images->id }}" class="img-a" href="{{ asset($images->image) }}" title="{{ $images->code }}">
                                    <img class="img-fluid fix-img shadow" src="{{ asset($images->image) }}" alt="" title="">
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 mt-3 mb-3">
                            <p>No Image available</p>
                        </div>
                    @endif   
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-12">
                    <p>“我們會為您精準搜尋最優質的盤源，並能在具有潛力的物業流出市場前推薦給您，歡迎聯絡我們視察物業！” 保誠物業。</p>
                    <p>物業的呎吋、價格或因應提供方之準確性及市場變化而有所不同，一切需以最終確認為準。</p>
                </div>
            </div> --}}
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
    </script>
</body>
</html>