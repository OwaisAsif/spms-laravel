<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    <style>
        body {
            font-size: 12px !important;
        }
        h6 {
            font-size: 1rem;
        }
        .divider {
            background-color: #274472;
            height: 5px;
            width: 75%;
        }
        .log_btn:hover {
            background-color: #189AB4;
            color: #fff;
        }
        .room-num {
            position: absolute;
            bottom: 0px;
            width: 100%;
        }
        .room-num input {
            width: calc((100% - 34px) / 3);
            background: rgba(255, 255, 255, 0.8);
            border: none;
            text-align: center;
            outline: none;
        }
        .share-extension {
            position: absolute;
            width: 60px;
            height: 50px;
            top: 0px;
            right: 0px;
        }
        .share-input {
            position: absolute;
            top: 10px;
            right: 25px;
            z-index: 10;
        }
        .list-group {
            height: 300px;
            background-color: skyblue;
            /* width: 200px; */
            overflow-y: scroll;
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
    </style>
</head>
<body class="bg-light">
    <section class="py-3">
        <div class="container bg-white" jstcache="0">
    
            <div class="row" jstcache="0">
                <!-- <form action="" method="post"> -->
                <div class="col-12" jstcache="0">
                    <div class="d-flex">
                        <h6 class="font-weight-bold ">Code: <span class="text-primary">{{ $property->code }}</span></h6>
                    </div>
                    <div class="divider mt-2 mb-2"></div>
    
                    
                    <!--<div class="divider mb-3"></div>-->
                    <div class="d-flex justify-content-between mt-2">
                        <input hidden="" id="building_address" value="駿業街43號">
                        <input hidden="" id="code" value="創匯1601">
                        <h6 class="font-weight-bold">Building Info: <span class="text-primary">{{ $property->building }}</span></h6>
                    </div>
                    <div class="divider mb-3"></div>
                        <div class="row mb-4" jstcache="0">
                            <div class="col-12 col-md-6 mb-4">
                            </div>
                            
                            <div class="col-12 col-md-6" jstcache="0">
                            </div>
                        </div>
                        
    
                    <!--</div>-->
                    <div class="divider mb-3"></div>
                    <h6 class="font-weight-bold">Building Info</h6>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">District: <span class="text-primary">{{ $property->district }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Address: <span class="text-primary">{{ $property->street }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Year: <span class="text-primary">{{ $property->year }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Floor: <span class="text-primary">{{ $property->floor }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Flat: <span class="text-primary">{{ $property->flat }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number of room(s): <span class="text-primary">{{ $property->no_room }}</span></p>
                        </div>
    
                        <div class="col-6">
                            <p class="font-weight-bold">Cargo Lift: <span class="text-primary">{{ $property->cargo_lift }}</span></p>
                        </div>
    
                        <div class="col-6">
                            <p class="font-weight-bold">Customer Lift: <span class="text-primary">{{ $property->customer_lift }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">24 hour: <span class="text-primary">{{ $property->tf_hr }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Entry Password: <span class="text-danger">{{ $property->enter_password }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Block: <span class="text-primary">{{ $property->block }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Number of Floor: <span class="text-primary">{{ $property->num_floors }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Car Park: <span class="text-primary">{{ $property->car_park }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Ceiling Height: <span class="text-primary">{{ $property->ceiling_height }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Air Conditioning: <span class="text-primary">{{ $property->air_con_system }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Building Loading: <span class="text-primary">{{ $property->building_loading }}</span></p>
                        </div>
                    </div>
    
                   
                    <div class="divider mb-2"></div>
                    <div class="d-flex justify-content-between mt-2">
                        <h6 class="font-weight-bold">Landlord Info</h6>
                    </div>
                    <div class="row">
    
                        <div class="col-12">
                            <p class="font-weight-bold">LandLord Name: <span class="text-primary">{{ $property->landlord_name }}</span>
                            </p>
                        </div>
    
                        <div class="col-12">
                            <div class="row ui-sortable" id="sortable-list">
                                <div class="col-12 d-flex item p-0 ui-sortable-handle" id="contact1" draggable="true">
                                    <p class="font-weight-bold w-50 pl-3"><span class="contactlabel">Contact 1:</span> <span class="text-primary cont__">{{ $property->contact1 }}</span></p>
                                
                                    <div class="d-flex w-50 pl-3">
                                        <p class="font-weight-bold mr-3"><span class="numberlabel">Number 1:</span> <span class="text-primary num__">{{ $property->number1 }}</span></p>
                                                                                        
                                        <a href="#" class="d-flex"><i class="text-success font-weight-bold fa fa-whatsapp fa" aria-hidden="true"></i></a>        
                                    </div>
                                </div>
                                <div class="col-12 d-flex item p-0 ui-sortable-handle" id="contact2" draggable="true">
                                    <p class="font-weight-bold w-50 pl-3"><span class="contactlabel">Contact 2:</span> <span class="text-primary cont__">{{ $property->contact2 }}</span></p>
                                
                                    <div class="d-flex w-50 pl-3">
                                        <p class="font-weight-bold mr-3"><span class="numberlabel">Number 2:</span> <span class="text-primary num__">{{ $property->number2 }}</span></p>
                                                                            </div>
                                </div>
                                <div class="col-12 d-flex item p-0 ui-sortable-handle" id="contact3" draggable="true">
                                    <p class="font-weight-bold w-50 pl-3"><span class="contactlabel">Contact 3:</span> <span class="text-primary cont__">{{ $property->contact3 }}</span></p>
                                
                                    <div class="d-flex w-50 pl-3">
                                        <p class="font-weight-bold"><span class="numberlabel">Number 3:</span> <span class="text-primary num__">{{ $property->number3 }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div id="itemClip" class="hidden"> <!-- Make sure this element exists with the correct ID -->
                            <!-- Content for itemClip -->
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Individual: <span class="text-primary">{{ $property->individual }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Separate: <span class="text-primary">{{ $property->separate }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Bank: <span class="text-primary">{{ $property->bank }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">Account: <span class="text-primary">{{ $property->bank_acc }}</span></p>
                        </div>
                        <div class="col-6 mb-2">
                            <p class="font-weight-bold">Remarks: <span class="text-primary">{{ $property->remarks }}</span></p>
                        </div>
    
                    </div>
                    <div class="divider mb-2"></div>
    
                    <div class="d-flex justify-content-between mt-2">
                        <h6 class="font-weight-bold">FTOD</h6>
                    </div>
    
                    <div class="row">
                        <div class="col-12">
                        <p class="font-weight-bold">Facilities: 
                            <span class="text-primary">{{ $property->facilities }}</span>
                        </p>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="font-weight-bold">Types: <span class="text-primary">{{ $property->types }}</span></p>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="font-weight-bold">Decorations: <span class="text-primary">{{ $property->decorations }}</span></p>
                        </div>
                        <div class="col-12 mt-3">
                            <p class="font-weight-bold">Usage 用途: <span class="text-primary">{{ $property->usage }}</span></p>
                        </div>
                        @if($property->yt_link_1 != null)
                            <div class="col-6 mt-3">
                                <iframe class="youtubeIframe" data-url="{{ $property->yt_link_1 }}" frameborder="0" style="width: 100%;height: 205px" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                <p class="font-weight-bold" style="word-break: break-all"> 大堂影片 Lobby Clip:<br><a class="text-primary" href="{{ $property->yt_link_1 }}">{{ $property->yt_link_1 }}</a></p>
                            </div>
                        @endif
                            <!-- =================-->
                        @if($property->yt_link_2 != null)
                            <div class="col-6 mt-3">
                                <iframe class="youtubeIframe" data-url="{{ $property->yt_link_2 }}" frameborder="0" style="width: 100%;height: 205px" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                                <p class="font-weight-bold" style="word-break: break-all">單位影片&nbsp;Property&nbsp;Clip:<br><a class="text-primary" href="{{ $property->yt_link_1 }}">https://www.youtube.com/shorts/FZC74pUr038?feature=share</a></p>
                            </div>
                        @endif
                            
                        <div class="col-12 mt-3">
                            <p class="font-weight-bold"><u>Other &amp; Expire Date</u></p>
                        </div>
    
                        <div class="col-12 mb-3">
                            @php
                            $others = json_decode($property->others, true);
                            $dates = json_decode($property->other_date, true);
                            $formats = json_decode($property->other_free_formate, true);
                            @endphp
    
                            @if (!empty($others) && is_array($others))
                                @foreach ($others as $index => $other)
                                    <p class="font-weight-bold">
                                        <span class="text-dark">{{ $other ?? 'N/A' }}</span>
                                        <span class="text-success">({{ $dates[$index] ?? 'N/A' }})</span>
                                        <span>({{ $formats[$index] ?? 'N/A' }})</span>
                                    </p>
                                @endforeach
                            @endif
                        </div>
    
                    </div>
                    
                    <div class="divider mb-2"></div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-bold">Size/Price</h6>
                    </div>
    
                    <div class="row mt-2">
                        <div class="col-6 col-md-12">
                            <p class="font-weight-bold">Gross sf: <span class="text-primary">{{ $property->gross_sf }}</span>
                            </p>
                        </div>
                        <div class="col-6 col-md-12">
                            <p class="font-weight-bold">Net sf: <span class="text-primary">{{ $property->net_sf }}</span></p>
                        </div>
                    </div>
                        <hr class="mt-1 mb-1">
                    <div class="row">
                        <div class="col-12">
                            <p class="font-weight-bold">Selling Price (M): <span class="text-primary">{{ $property->selling_price }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">G@: <span class="text-primary">{{ $property->selling_g }}</span></p>
                        </div>
                        <div class="col-6">
                            <p class="font-weight-bold">N@: <span class="text-primary">{{ $property->selling_n }}</span></p>
                        </div>
                    </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold">Rental Price: <span class="text-primary">{{ $property->rental_price }}</span></p>
                            </div>
                            <div class="col-6">
                                <p class="font-weight-bold">G@: <span class="text-primary">{{ $property->rental_g }}</span></p>
                            </div>
                            <div class="col-6">
                                <p class="font-weight-bold">N@: <span class="text-primary">{{ $property->rental_n }}</span></p>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold">Mgmf: <span class="text-primary">{{ $property->mgmf }}</span></p>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold">Rate: <span class="text-primary">{{ $property->rate }}</span></p>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold">Land: <span class="text-primary">{{ $property->land }}</span></p>
                            </div>
                        </div>
                        <hr class="mt-1 mb-1">
                        <div class="row mb-1">
                            <div class="col-12">
                                <p class="font-weight-bold">Oths: <span class="text-primary">{{ $property->oths }}</span></p>
                            </div>
                        </div>
                    <hr class="w-75 m-0">
                    <div class="divider mb-2"></div>
    
    
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <p class="font-weight-bold mt-2">Admin Comment</p>
                                <div class="divider mb-2"></div>
                                <p class="font-weight-bold text-primary"></p>
                            </div>
                            <div class="col-12">
                                <p class="font-weight-bold d-flex justify-content-between mt-2 mb-1">
                                    <span class="mt-2">
                                        ben ng Comment
                                        (16-07-2024)
                                    </span>
                                    
                                </p>
                                <div class="divider mb-2"></div>
                                <p class="font-weight-bold mt-2">Agent Comment
                                <span style="float:right">
                                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#comment_modal">Comment</button>
                                    </span>
                                    </p>
                                <div class="divider mb-2"></div>
                                <p class="font-weight-bold text-primary"></p>
                            </div>
                        </div>
                    </div>
                    <!-- <h6 class="font-weight-bold mt-2">Last Seen By</h6> -->
                    <!-- <div class="divider mb-2"></div> -->
                    <p class="font-weight-bold">Username: <span class="text-primary">{{ $property->agent_name }} ({{ \Carbon\Carbon::parse($property->building_created_at)->format('d-m-Y') }})</span></p>
    
    
                    <h6 class="font-weight-bold mt-2">Photos</h6>
                    <div class="divider mb-2"></div>
                    <div class="w-100 text-right" id="make_grid" style="display: none;">
                        <a class="btn btn-info btn-sm" target="_blank" href="#">make grid</a>
                    </div>
                    <div class="popup-gallery">
                        <div class="row">
                            @foreach ($property->photos  as $images)
                            <div class="col-4 mt-3 mb-5">
                                <div style="position: absolute; bottom: -35px; left: 15px;">
                                    @if($images->yt_link != null)
                                        <button onclick="setLink('{{ $images->yt_link }}')" data-toggle="modal" data-target="#imageDetailModel" class="p-1 text-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-brand-youtube">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 3a5 5 0 0 1 5 5v8a5 5 0 0 1 -5 5h-12a5 5 0 0 1 -5 -5v-8a5 5 0 0 1 5 -5zm-9 6v6a1 1 0 0 0 1.514 .857l5 -3a1 1 0 0 0 0 -1.714l-5 -3a1 1 0 0 0 -1.514 .857z"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                        
                                <div class="room-num">
                                    <input type="input" data-field="room_number" data-photo-id="{{ $images->id }}" value="{{ $images->room_number }}" placeholder="Room number">
                                    <input type="input" data-field="size" data-photo-id="{{ $images->id }}" value="{{ $images->size }}" placeholder="Size">
                                    <input type="input" data-field="price" data-photo-id="{{ $images->id }}" value="{{ $images->price }}" placeholder="Price">
                                </div>
                                <a href="{{ asset($images->image) }}" title="{{ $images->code }}">
                                    <img class="img-fluid fix-img shadow h-100" src="{{ asset($images->image) }}" alt="" width="100%">
                                </a>
                            </div>
                            @endforeach
                        </div>                    
                    </div>
                </div>
                <!-- </form> -->
            </div>
    
        </div>
    
    </section>
    <section class="p-2 mt-2" style="background-color: #fff;">
        <footer>
            <div class="container social_icon text-center">
                <hr class="font-weight-bold">
                <small class="text-center text-muted">Copyright 2024</small>
            </div>
        </footer>
    </section>

    {{-- Comments Modal --}}
    <div class="modal fade" id="comment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form id="saveComment">
                <!-- Modal body -->
                <div class="modal-body">
                    <label class="form-label">Comment:</label>
                    <textarea class="form-control" name="comment"></textarea>
                    <input type="hidden" id="code_comment" name="code_comment" value="廣生行1608">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </form>
            {{-- <hr class="my-2"> --}}
            <h4 class="modal-header mt-3" style="border-top: .7px solid rgba(0, 0, 0, .2);">All Comments</h4>
            <div id="comments_list"><div class="px-4"> &nbsp; (ben ng Date: 2024-10-23 05:51:18)</div><hr class="my-2"></div>
        </div>
        </div>
    </div>


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

        // $('.popup-gallery .room-num input').on('keyup', function() {
        //     const photoId = $(this).data('photo-id');
        //     const field = $(this).data('field');
        //     const value = $(this).val();

        //     $.ajax({
        //         url: '/update-room',
        //         type: 'POST',
        //         data: {
        //             photo_id: photoId,
        //             field: field,
        //             value: value,
        //         },
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         success: function(response) {
        //             console.log(response.message);
        //         },
        //         error: function(xhr) {
        //             console.error('Error:', xhr.responseText);
        //         }
        //     });
        // });

        // $(document).on('click', '[data-toggle="modal"]', function() {
        //     const videoId = $(this).data('id');
        //     const ytLink = $(this).data('yt');

        //     $('#edit-video-id').val(videoId);
        //     $('#edit-video-link').val(ytLink);
        // });

        $(document).ready(function () {
            $('.youtubeIframe').each(function () {
                let youtubeUrl = $(this).data('url');
                let embedUrl = '';
                if (youtubeUrl.includes('/shorts/')) {
                    let shortsId = youtubeUrl.split('/shorts/')[1];
                    embedUrl = "https://www.youtube.com/embed/" + shortsId;
                }
                else if (youtubeUrl.includes('?v=')) {
                    let videoId = youtubeUrl.split('?v=')[1];
                    embedUrl = "https://www.youtube.com/embed/" + videoId;
                }
                else {
                    let urlParts = youtubeUrl.split('/');
                    let videoIdWithParams = urlParts[urlParts.length - 1];
                    let videoId = videoIdWithParams.split('?')[0];
                    embedUrl = "https://www.youtube.com/embed/" + videoId;
                }

                $(this).attr('src', embedUrl);
            });
        });
        
        function setLink(youtubeUrl) {
            embedUrl = ''
            if (youtubeUrl.includes('/shorts/')) {
                let shortsId = youtubeUrl.split('/shorts/')[1];
                embedUrl = "https://www.youtube.com/embed/" + shortsId;
            } else if(youtubeUrl.includes('?v=')) {
                let videoId = youtubeUrl.split('?v=')[1];
                embedUrl = "https://www.youtube.com/embed/" + videoId;
            } else {
                let urlParts = youtubeUrl.split('/');
                let videoIdWithParams = urlParts[urlParts.length - 1];
                let videoId = videoIdWithParams.split('?')[0];
                embedUrl = "https://www.youtube.com/embed/" + videoId;
            }
            
            
            $('#room-video')[0].src = embedUrl
        }

    </script>
</body>
</html>