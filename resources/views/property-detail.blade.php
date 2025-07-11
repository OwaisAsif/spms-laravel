@extends('layouts.app')

@section('styles')
    <!-- Magnific Popup core CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    {{-- <style>
        body {
            font-size: 12px !important;
        }
        h6 {
            font-size: 1rem;
        }
        .divider {
            background-color: #274472;
            height: 5px;
            width: 100%;
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
        .fix-img {
            height: 300px !important;
            object-fit: cover;
            width: 100% !important;
            max-width: 100%;
            display: block;
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
    </style> --}}
@endsection

@section('content')
<section class="py-3">
    <div class="container bg-white" jstcache="0">

        <div class="row" jstcache="0">
            <div class="col-12 my-3 text-primary" style="cursor:pointer">
                <h6>
                    @if($property->district != null)
                        <a style="text-decoration: underline" href="{{ route('admin.search.page') }}?type=district&value={{ urlencode($property->district) }}">{{ $property->district }}</a> &gt; 
                    @endif
                    <a style="text-decoration: underline" href="{{ route('admin.search.page') }}?type=building&value={{ urlencode($property->building) }}">{{ $property->building }}</a> &gt; 
                    永發隆3
                </h6>
            </div>
            <div class="col-12 mb-4">
                <input type="text" id="my_code" class="form-control " placeholder="Keyword">
                <div id="property_output"></div>
            </div>
            
            <div class="col-12" jstcache="0">
                <div class="d-flex">
                    <h6 class="font-weight-bold ">Code: <span class="text-primary">{{ $property->code }}</span></h6>
                    <a href="{{ route('edit.property.detail', $property->code) }}" class="btn btn-sm ml-5 log_btn1" style="color: #212529;">Edit</a>
                    @php
                        $sharedProperties = json_decode(auth()->user()->properties_share_list, true) ?? [];
                    @endphp
                    <span class="ml-5">
                        Mark:
                        <input type="checkbox" data-share="{{ $property->building_id }}" class="share" id="property-share-input" {{ in_array($property->building_id, $sharedProperties) ? 'checked' : '' }}>
                    </span>
                </div>
                <a href="{{ route('edit.code', $property->code) }}">Edit Code</a>
                <div class="divider mt-2 mb-2"></div>

                
                <!--<div class="divider mb-3"></div>-->
                <div class="d-flex justify-content-between mt-2">
                    <input hidden="" id="building_address" value="{{ $property->street }}">
                    <input hidden="" id="code" value="{{ $property->code }}">
                    <h6 class="font-weight-bold">Building Info: <span class="text-primary">{{ $property->building }}</span></h6>
                    <a class="mt-2 ml-2 btn btn-sm btn-info" href="{{ route('edit.buildinginfo', $property->code) }}">Edit Building Info</a>
                </div>
                <div class="divider mb-3"></div>
                <div class="row mb-4">
                    <div class="col-12 col-md-6 mb-4">
                        <div id="map"></div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div id="pano"></div>
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
                    <a class="mt-2 ml-2 btn btn-sm btn-info" href="{{ route('edit.landlord', $property->code) }}">Edit Landlord</a>
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
                                    <p class="font-weight-bold mr-3"><span class="numberlabel">Number 1:</span>
                                        <span class="text-primary num__" data-full-number="{{ $property->number1 }}">{{ $property->number1 }}</span>
                                        <span class="eye-icon"
                                            style="cursor: pointer;"
                                            data-building-code="{{ $property->code }}"
                                            data-user-id="{{ auth()->user()->id }}">
                                            
                                        </span>
                                    </p>
                                     
                                    <div style="{{ $property->number1 ? '' : 'display: none;' }}">
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $property->number1) }}" class="d-flex">
                                            <i class="text-success font-weight-bold fa fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex item p-0 ui-sortable-handle" id="contact2" draggable="true">
                                <p class="font-weight-bold w-50 pl-3"><span class="contactlabel">Contact 2:</span> <span class="text-primary cont__">{{ $property->contact2 }}</span></p>
                                
                                <div class="d-flex w-50 pl-3">
                                    <p class="font-weight-bold mr-3">
                                        <span class="numberlabel">Number 2:</span>
                                        <span class="text-primary num__" data-full-number="{{ $property->number2 }}">{{ $property->number2 }}</span>
                                        <span class="eye-icon"
                                            style="cursor: pointer;"
                                            data-building-code="{{ $property->code }}"
                                            data-user-id="{{ auth()->user()->id }}">
                                            
                                        </span>
                                    </p>
                                    <div style="{{ $property->number2 ? '' : 'display: none;' }}">
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $property->number2) }}" class="d-flex">
                                            <i class="text-success font-weight-bold fa fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-flex item p-0 ui-sortable-handle" id="contact3" draggable="true">
                                <p class="font-weight-bold w-50 pl-3">
                                    <span class="contactlabel">Contact 3:</span>
                                    <span class="text-primary cont__">{{ $property->contact3 }}</span>
                                </p>
                            
                                <div class="d-flex w-50 pl-3">
                                    <p class="font-weight-bold mr-3"><span class="numberlabel">Number 3:</span>
                                        <span class="text-primary num__" data-full-number="{{ $property->number3 }}">{{ $property->number3 }}</span>
                                        <span class="eye-icon"
                                            style="cursor: pointer;"
                                            data-building-code="{{ $property->code }}"
                                            data-user-id="{{ auth()->user()->id }}">
                                            
                                        </span>
                                    </p>
                                    <div style="{{ $property->number3 ? '' : 'display: none;' }}">
                                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $property->number3) }}" class="d-flex">
                                            <i class="text-success font-weight-bold fa fa-whatsapp" aria-hidden="true"></i>
                                        </a>
                                    </div>
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
                        <p class="font-weight-bold">Management Companys: <span class="text-primary">{{ $property->management_company }}</span></p>
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
                    <a class="mt-2 ml-2 btn btn-sm btn-info" href="{{ route('edit.ftod', $property->code) }}">Edit FTO</a>
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
                            <p class="font-weight-bold" style="word-break: break-all">單位影片&nbsp;Property&nbsp;Clip:<br><a class="text-primary" href="{{ $property->yt_link_2 }}">{{ $property->yt_link_2 }}</a></p>
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
                        $today = now()->format('Y-m-d');
                        @endphp

                        @if (!empty($others) && is_array($others))
                            @foreach ($others as $index => $other)
                                @php
                                    $date = $dates[$index] ?? null;
                                @endphp
                                @if ($date && $date >= $today)
                                    <p class="font-weight-bold">
                                        <span class="text-dark">{{ $other ?? 'N/A' }}</span>
                                        <span class="text-success">({{ \Carbon\Carbon::parse($dates[$index] ?? '')->format('d-m-Y') }})</span>
                                        <span>({{ $formats[$index] ?? 'N/A' }})</span>
                                    </p>
                                @else
                                    @if( $other == 'Rent Out 巳租')
                                        <p class="font-weight-bold">
                                            <span class="text-dark">{{ $other ?? 'N/A' }}</span>
                                            <span class="text-danger">({{ \Carbon\Carbon::parse($dates[$index] ?? '')->format('d-m-Y') }})</span>
                                            <span>({{ $formats[$index] ?? 'N/A' }})</span>
                                        </p>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                    @if(!empty($others) && is_array($others))
                        <div class="col-3 mt-3 mb-3">
                            <form action="{{ route('ftod.others', $property->building_id) }}" method="post">
                                @csrf
                                <button type="submit" name="submit" class="btn btn-block font-weight-bold" style="background: #fff">RO</button>
                            </form>
                        </div>
                    @endif
                </div>
                
                <div class="divider mb-2"></div>
                <div class="d-flex justify-content-between">
                    <h6 class="font-weight-bold">Size/Price</h6>
                    <a class="btn btn-sm btn-info" href="{{ route('edit.size.price', $property->code) }}">Edit Size/Price</a>
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
                                    {{ $property->agent_name }} ({{ \Carbon\Carbon::parse($property->building_created_at)->format('d-m-Y') }})
                                </span>
                                
                            </p>
                            <div class="divider mb-2"></div>
                            <p class="font-weight-bold mt-2">Agent Comment
                            <span style="float:right">
                                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#comment_modal">Comment</button>
                                </span>
                                </p>
                            <div class="divider mb-2"></div>
                            <p class="font-weight-bold text-primary">
                                    {{ $latestComment->comment ?? ''}}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- <h6 class="font-weight-bold mt-2">Last Seen By</h6> -->
                <!-- <div class="divider mb-2"></div> -->
                <p class="font-weight-bold">Username: <span class="text-primary">{{ $property->agent_name }} ({{ \Carbon\Carbon::parse($property->building_created_at)->format('d-m-Y') }})</span></p>


                <h6 class="font-weight-bold mt-2">Photos</h6>
                <div class="divider mb-2"></div>

                {{-- @php
                    $sharedImages = json_decode(auth()->user()->images_share_list, true) ?? [];
                @endphp --}}

                <div class="d-flex justify-content-end">
                    <div class="mr-2" id="make_grid" style="display: none;">
                        <a class="btn btn-info btn-sm" target="_blank" href="{{ route('grid', $property->code) }}">make grid</a>
                        <a class="btn btn-success btn-sm text-white" id="ai-decor-btn">A.I Interior Decor</a>
                    </div>
                    <div id="duplicate_images" style="display: none;">
                        @if(Auth()->user()->image_merge_permission == 1)
                            <button class="btn btn-info btn-sm" onclick="duplicateImagesToProperties('{{ $property->building }}', '{{ $property->code }}')">Share images with same building</button>
                        @endif
                    </div>
                </div>

                <div class="popup-gallery">
                    <div class="row">
                        @foreach ($property->photos  as $images)
                        <div class="col-4 mt-3 mb-5">
                            @php
                                $sharedImages = json_decode(auth()->user()->images_share_list, true) ?? [];
                            @endphp
                            <input type="checkbox" class="share-input" id="share-photo-input" data-share="{{ $images->id }}" {{ in_array($images->id, $sharedImages) ? 'checked' : '' }}>
                            <div class="share-extension"></div>
                    
                            <div style="position: absolute; bottom: -35px; left: 15px;">
                                <button data-toggle="modal" data-id="{{ $images->id }}" data-yt="{{ $images->yt_link }}" data-target="#imageEditModel" class="p-1 text-succes">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                </button>
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
                                <img class="img-fluid fix-img shadow h-100" src="{{ asset($images->image) }}" alt="{{ $property->code }}" width="100%" title="{{ $property->code }}">
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

    <div class="modal fade" id="imageEditModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('photo.ytLink') }}" method="POST">
                    @csrf

                    <input name="image_id" id="edit-video-id" type="hidden">
                    <div class="row">
                        <div class="col-12">
                            <input name="link" id="edit-video-link" type="text" class="form-control">
                        </div>
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-success btn-block">
                                Edit Video
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        </div>
    </div>

    {{-- yt link modal --}}
    <div class="modal fade" id="imageDetailModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rom Video</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <iframe src="" frameborder="0" id="room-video" style="width: 100%;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
            </div>
        </div>
        </div>
    </div>


    {{-- Comments Modal --}}
    <!-- Modal -->
    <div class="modal fade" id="comment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <!-- Modal body -->
                <div class="modal-body">
                    <label class="form-label">Comment:</label>
                    <textarea class="form-control" name="comment"></textarea>
                    <input type="hidden" id="code_comment" name="code_comment" value="{{ $property->code }}">
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </form>
            {{-- <hr class="my-2"> --}}
            <h4 class="modal-header mt-3" style="border-top: .7px solid rgba(0, 0, 0, .2);">All Comments</h4>
            <div id="comments_list">
                <div class="px-4"> &nbsp; ({{ $property->agent_name }} Date: {{ $property->building_created_at }})</div><hr class="my-2">
                @if ($property->comments->isNotEmpty())
                    @foreach ($property->comments as $comment)
                        <div class="px-4"> &nbsp; {{ $comment->comment }} ({{ $comment->user->name ?? '' }} {{ $comment->created_at }})</div>
                        <hr class="my-2">
                    @endforeach
                @endif
            </div>
        </div>
        </div>
    </div>

@endsection

@section('scripts')
<!-- Magnific Popup core JS file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

    $('.popup-gallery .room-num input').on('keyup', function() {
        const photoId = $(this).data('photo-id');
        const field = $(this).data('field');
        const value = $(this).val();

        $.ajax({
            url: '/update-room',
            type: 'POST',
            data: {
                photo_id: photoId,
                field: field,
                value: value,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response.message);
            },
            error: function(xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
    });

    $(document).on('click', '[data-toggle="modal"]', function() {
        const videoId = $(this).data('id');
        const ytLink = $(this).data('yt');

        $('#edit-video-id').val(videoId);
        $('#edit-video-link').val(ytLink);
    });

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
    
    $(document).ready(function () {
        $('#my_code').keyup(function () {
            let query = $(this).val();
            if (query !== '') {
                $.ajax({
                    type: "POST",
                    url: "/search-property",
                    data: {
                        query: query,
                        _token: $('meta[name="csrf-token"]').attr('content') 
                    },
                    success: function (response) {
                        $('#property_output').fadeIn();
                        $('#property_output').html(response);
                    }
                });
            } else {
                $('#property_output').fadeOut();
                $('#property_output').html("");
            }
        });

        $('#property_output').on('click', 'li', function () {
            $('#my_code').val($(this).text());
            $('#property_output').fadeOut();
        });
    });

    $(document).on('click', '#property-share-input', function () {
        let buildingId = $(this).data('share');

        $.ajax({
            url: "{{ route('property.share') }}",
            type: "POST",
            data: {
                building_id: buildingId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                updateShareCount();
                // if (response.success) {
                //     alert(response.message);
                // }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

    $(document).on('click', '#share-photo-input', function () {
        let imageId = $(this).data('share');

        $.ajax({
            url: "{{ route('share.image') }}",
            type: "POST",
            data: {
                image_id: imageId,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                updateShareCount();
                // if (response.success) {
                //     alert(response.message);
                // }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

    $(document).ready(function() {
        function updateGridButton() {
            let hasCheckedImages = $('.share-input:checked').length > 0;
            if (hasCheckedImages) {
                $('#make_grid').show();
                $('#duplicate_images').show();
            } else {
                $('#make_grid').hide();
                $('#duplicate_images').hide();
            }
        }
        updateGridButton();
        $('.share-input').change(function() {
            updateGridButton();
        });
    });

    let selectedImages = [];
    $(document).ready(function () {
        $('.share-input:checked').each(function () {
            const imageId = $(this).data('share');
            if (!selectedImages.includes(imageId)) {
                selectedImages.push(imageId);
            }
        });
        // console.log('Initial selected images:', selectedImages);
    });
    
    $(document).on('change', '.share-input', function () {
        const imageId = $(this).data('share');
        if ($(this).is(':checked')) {
            if (!selectedImages.includes(imageId)) {
                selectedImages.push(imageId);
            }
        } else {
            selectedImages = selectedImages.filter(id => id !== imageId);
        }
        // console.log('Updated selected images:', selectedImages);
    });

    function duplicateImagesToProperties(buildingName, code) {
        if (selectedImages.length === 0) {
            alert("Please select at least one image to share.");
            return;
        }

        $.ajax({
            url: '{{ route('images.duplicate') }}',
            type: 'POST',
            data: {
                code: code,
                building: buildingName,
                images: selectedImages,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                $('#duplicate_images').hide();
                // alert(response.message);
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while duplicating images.");
            }
        });
    }

    // Conatct Drag drop and hide show 
    $(document).ready(function () {
        $("#sortable-list").sortable({
            update: function () {
                var contacts = $('.ui-sortable-handle');
                var code = $('#code').val();

                contacts.each(function (index) {
                    $(this).find('.contactlabel').text('Contact ' + (index + 1) + ':');
                    $(this).find('.numberlabel').text('Number ' + (index + 1) + ':');
                });

                let formData = new FormData();
                formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
                formData.append("contact1", contacts.eq(0).find('.cont__').text());
                formData.append("contact2", contacts.eq(1).find('.cont__').text());
                formData.append("contact3", contacts.eq(2).find('.cont__').text());
                formData.append("number1", contacts.eq(0).find('.num__').data("full-number") || "");
                formData.append("number2", contacts.eq(1).find('.num__').data("full-number") || "");
                formData.append("number3", contacts.eq(2).find('.num__').data("full-number") || "");
                formData.append("code", code);

                $.ajax({
                    type: "POST",
                    url: "{{ route('contacts.updateOrder') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (response) {
                        console.log("Response:", response);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        });

        $(document).ready(function () {
            $(".num__").each(function () {
                let countryCode = "+852";
                let fullNumber = countryCode + $(this).data("full-number")?.toString();
                if (fullNumber) {
                    let maskedNumber = fullNumber.slice(0, 4) + '****' + fullNumber.slice(-3);
                    $(this).text(maskedNumber);
                    $(this).next(".eye-icon").html("👁️");
                }
            });

            $(".eye-icon").on("click", function () {
                let countryCode = "+852";
                let numberSpan = $(this).prev(".num__");
                let fullNumber = countryCode + numberSpan.data("full-number")?.toString();
                let currentText = numberSpan.text();

                if (currentText.includes("****")) {
                    numberSpan.text(fullNumber);
                    $(this).html("🙈");
                } else {
                    let maskedNumber = fullNumber.slice(0, 4) + '****' + fullNumber.slice(-3);
                    numberSpan.text(maskedNumber);
                    $(this).html("👁️");
                }
            });
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

<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyACk1RzpwGH2o8goef4pgIP8C1-_BNDCD0&callback=initialize&v=weekly"></script>
@endsection