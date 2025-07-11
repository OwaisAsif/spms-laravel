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
        body {
            font-weight: var(--bs-body-font-weight);
            line-height: var(--bs-body-line-height);
        }
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
            margin-top: 0;
            margin-bottom: 1rem;
        }
        p, button, small, input {
            font-family: 'Lato', sans-serif;
        }
        .share-list.container.wide {
            max-width: 90%;
        }
        .share-note {
            color: #ff9900;
        }
        .logo-img{
            width: 100%;
            height: 200px !important;
        }
        img {
            width: 100%;
        }
        .share-note.blue {
            color: #007bff;
        }
        .map,.pano {
            float: left;
            height: 200px;
            width: 100%;
        }
        .mfp-container {
            position: fixed;
        }
        .font-responsive {
            font-size: 25px;
        }
        /* .logo-img{
            width: 300px;
            height: 200px;
        } */
        .footer-t {
            font-size: 15px;
        }
        /* .fix-img {
            height: 250px;
            width: 250px;
        } */
        @media screen and (max-width: 720px) {
            .font-responsive {
                font-size: 12px; /* Font size for mobile screens */
            }
            h2 {
                font-size: 15px; /* Font size for mobile screens */
            }
        }
    </style>
</head>
<body>

    <section id="share-pdf" style="padding: 0 0 50px 0;">
        @foreach ($properties as $property)
            @if ($loop->first)
                @php
                    $options = json_decode($propertyOptions, true) ?? [];
                @endphp
                <div class="container share">
                    <div class="popup-gallery">
                        <div class="row">
                            <div class="col-6" style="height: 30px; background-image: url({{ asset('assets/logos/print-footer.png') }})"></div>
                            <div class="col-6"></div>
                            <div class="col-md-6 col-6 d-flex">
                                <h1 class="my-auto fw-bold" style="font-weight: 700;">{{ $property->building }}</h1>
                            </div>
                            <div class="col-md-6 col-6">
                                <img src="{{ asset('assets/logos/print-logo.png') }}" class="logo-img">
                            </div>
                            <br>
                            @php
                                $individual_comments = json_decode($individualComments, true);
                                $valuesToCheck = ['building', 'street', 'district', 'floor', 'flat', 'block', 'rental_price', 'rental_g', 'rental_n', 'selling_price', 'selling_g', 'selling_n', 'gross_sf', 'net_sf', 'mgmf', 'rate', 'land', 'oths', 'youtube_link']; 
                            @endphp
                            @if(count(array_intersect($valuesToCheck, $options)))
                                <div class="col-6 px-2">
                                    <div class="accordion-body code-{{ $property->code }}">
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
                                        {{-- <span class="font-responsive">載貨電梯: <span style="color: blue"></span></span><br>
                                        <span class="font-responsive">載客電梯: <span style="color: blue"></span></span><br>
                                        <span class="font-responsive">最高樓層: <span style="color: blue">0</span></span><br>
                                        <span class="font-responsive">停車場: <span style="color: blue"></span></span><br>
                                        <span class="font-responsive">樓層高度: <span style="color: blue"></span></span><br>
                                        <span class="font-responsive">冷氣系統: <span style="color: blue"></span></span><br>
                                        <span class="font-responsive">樓面承重: <span style="color: blue"></span></span><br> --}}
                                    </div>
                                </div>
                            @endif
                            <div class="col-6">
                                <div class="row">
                                    @foreach ($property->photos  as $images)
                                        @php
                                            $imgsOptions = is_array($imgsOptions) ? $imgsOptions : json_decode($imgsOptions, true);
                                            $imageDetails = isset($imgsOptions[$images->id]) ? $imgsOptions[$images->id] : null;
                                        @endphp

                                        <div class="col-6 mt-3 mb-3 yt-link" data-yt-link="{{ asset($images->original_image) }}" data-render-id="0觀中3期12V">
                                            <a id="{{ $images->code }}" href="{{ asset($images->original_image) }}" title="{{ $images->code }}">
                                                <img class="img-fluid fix-img shadow" src="{{ asset($images->square_image) }}" alt="" title="{{ $imageDetails['note'] ?? '' }}" alt="">
                                            </a>
                                            <div class='share-note blue'>{{ $imageDetails['note'] ?? '' }}</div>
                                        </div>
                                    @endforeach
                                    {{-- <div class="col-6 mt-3 mb-3 yt-link" data-yt-link="{{ asset('assets/default-imgs/building-2.jpg') }}" data-render-id="1觀中3期12V">
                                        <a id="1觀中3期12V" href="{{ asset('assets/default-imgs/building-2.jpg') }}">
                                            <img class="img-fluid fix-img shadow" src="{{ asset('assets/default-imgs/building-2.jpg') }}" alt="">
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3" id="print-btn">
                            <a href="{{ route('share') }}" class="btn btn-danger btn-sm">Go Back</a>
                            <button class="btn btn-success btn-sm"  onclick="printPDF()">Print PDF</button>
                        </div>
                        <div>
                            <br> <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4 mt-4">
                            <p class="footer-t">物業放盤情況須以最終合約為準。以上資料僅供參考，未經核實，須自行視察確認。本公司或業主不對資料準確性提供保證。物業描述、包括價格，面積呎吋，大小，用途，比例等資料僅作一般參考，不保證其完整或正確。The property listing details are subject to the final contract. The above information is for reference only and has not been verified; you are advised to conduct your own inspections to confirm. Neither our company nor the owner guarantees the accuracy of this information. Property descriptions, including price, square footage, size, usage, and proportions, are provided for general reference only and are not guaranteed to be complete&nbsp;or&nbsp;accurate.</p>
                        </div>
                    </div>
                    <img src="{{ asset('assets/logos/print-footer.png') }}" style="position:absolute; left: 0;">
                </div>
            @endif
        @endforeach
        {{-- <div class="modal fade" id="imageDetailModel">
            <div class="modal-dialog" style="width: 800px; max-width: 100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Room Video</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    <div class="modal-body" style="height: 500px">
                        <iframe src="" frameborder="0" id="room-video" style="width: 100%; height: 100%" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div> --}}
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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

        // function printPDF() {
        //     let oldViewPort = $('meta[name="viewport"]').attr("content");
        //     $('meta[name="viewport"]').attr("content", "width=1200");

        //     const element = $('#share-pdf')[0]; // Convert jQuery object to native DOM element
        //     const { jsPDF } = window.jspdf;

        //     html2canvas(element).then(canvas => {
        //         const imgData = canvas.toDataURL('image/png');
        //         const pdf = new jsPDF('p', 'mm', 'a4');
        //         const pdfWidth = pdf.internal.pageSize.getWidth();
        //         const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

        //         pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        //         pdf.save('share-pdf.pdf');

        //         $('meta[name="viewport"]').attr("content", oldViewPort);
        //     });
        // }

        // $(document).ready(function () {
        //     $('#print-btn').on('click', function () {
        //         printPDF();
        //     });

        //     $(document).on('keydown', function (event) {
        //         if (event.ctrlKey && event.key.toLowerCase() === 'q') {
        //             event.preventDefault();
        //             printPDF();
        //         }
        //     });
        // });

        function printPDF() {
            $('#print-btn').hide();

            let oldViewPort = $('meta[name="viewport"]').attr("content");
            $('meta[name="viewport"]').attr("content", "width=1200");

            const element = $('#share-pdf')[0];
            const { jsPDF } = window.jspdf;

            html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('share-pdf.pdf');
                $('meta[name="viewport"]').attr("content", oldViewPort);
                $('#print-btn').show();
            });
        }

        $(document).ready(function () {
            $(document).on('keydown', function (event) {
                if (event.ctrlKey && event.key.toLowerCase() === 'q') {
                    event.preventDefault();
                    printPDF();
                }
            });
        });

    </script>
</body>
</html>