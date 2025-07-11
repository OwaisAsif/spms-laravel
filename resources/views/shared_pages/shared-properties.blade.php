<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $comment ?? 'COmment' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    <style>
        [data-code-span] {
            font-size: 14px;
        }
        .comment{
            font-size: 22pt !important;
        }
        .container.share {
            font-size: 20pt;
        }
        .share-list .img-overflow {
            overflow: hidden;
            height: 95px;
        }
        .share-list .img-overflow img {
            height: 100%;
        }
        .share-list img {
            margin-right: 10px;
        }
        nav img, .share-list img {
            width: auto;
        }
        span {
            font-family: 'Lato', sans-serif;
        }
        .mfp-img-mobile .mfp-close {
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
        p {
            margin: 0;
        }
        .share-list.container.wide {
            max-width: 90%;
        }
    </style>
</head>
<body>
    <section>
        <div class="container share share-list wide">
            <div class="row">
                <div class="col-12 comment">{{ $comment }}</div>
            </div>
            @foreach($propertyDetails as $property)
                <div class="row">
                    <div class="col-4 comment">
                        <a href="{{ route('share.property.details', ['code' => $property->code, 'link' => $link]) }}" target="_blank">{{ $property->code }}</a>
                        <br>
                        @if($showCode === 'yes')
                            <span data-code-span="{{ $property->code }}"></span>
                        @endif
                    </div>
                    <div class="img-overflow popup-gallery col-8 mb-3">
                        @foreach($property->photos as $photo)
                            <a href="{{ asset($photo->image) }}" title="{{ $images->code }}">
                                <img src="{{ asset($photo->image) }}" alt="">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        <div class="row mt-5">
            <div class="col-12">
                <p>“我們會為您精準搜尋最優質的盤源，並能在具有潛力的物業流出市場前推薦給您，歡迎聯絡我們視察物業！” 保誠物業。</p>
                <p>物業的呎吋、價格或因應提供方之準確性及市場變化而有所不同，一切需以最終確認為準。</p>
            </div>
        </div>
    </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery and DataTables Scripts -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Magnific Popup core JS file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.popup-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                tLoading: 'Loading image #%curr%...',
                mainClass: 'mfp-img-mobile',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                image: {
                    tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
                    titleSrc: function(item) {
                        return item.el.attr('title') || 'Image';
                    }
                }
            });

            let codes = $('[data-code-span]').map(function() {
                return $(this).data('code-span');
            }).get();

            $.ajax({
                type: "POST",
                url: "/fetch-property-details",
                data: {
                    codes: codes,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    response.forEach(function(p) {
                        let span = $('[data-code-span="' + p.code + '"]')[0];
                        if (span) {
                            let otherFreeFormatted = '';
                            if (p.other_free_formate) {
                                try {
                                    let parsed = JSON.parse(p.other_free_formate);
                                    otherFreeFormatted = Array.isArray(parsed) ? parsed.join(', ') : '';
                                } catch (e) {
                                    otherFreeFormatted = p.other_free_formate;
                                }
                            }
                            span.innerHTML = `
                                <p>Gross SF: ${p.gross_sf || ''}</p>
                                ${p.selling_price !== '0.00' ? `<p class="d-none">Selling Price: ${p.selling_price || ''}</p>` : ''}
                                ${p.selling_g !== '0.00' ? `<p class="d-none">G@: ${p.selling_g || ''}</p>` : ''}
                                <p>Rental Price: ${p.rental_price || ''}</p>
                                <p>G@: ${p.rental_g || ''}</p>
                                <p>Oths: ${p.oths || ''}</p>
                                ${otherFreeFormatted ? `<p>Others: <span style="color: white; background-color: blue; padding: 2px">${otherFreeFormatted}</span></p>` : ''}
                            `;
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        });
    </script>
</body>
</html>