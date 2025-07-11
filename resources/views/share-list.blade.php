@extends('layouts.app')

@section('styles')
<!-- Magnific Popup core CSS file -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
{{-- <style>
    .share-list .container {
        background-color: white;
        padding: 25px;
    }
    section {
        padding: 10px 10px;
    }
    .share-list .img-overflow img {
        height: 90px;
    }
    .share-list .edit {
        top: 10px;
        right: 10px;
        position: absolute;
    }
    .share-list textarea.comment {
        top: 0px;
        right: 15px;
        left: 15px;
        bottom: 0px;
        position: absolute;
        width: auto;
    }
    .log_btn {
        background-color: #05445E;
        transition: 0.7s;
        color: #fff;
    }
    .log_btn:hover {
        background-color: #189AB4;
        color: #fff;
    }
    .mfp-img {
        height: 100vh;
        width: auto;
        max-width: 100%;
    }
    .share-list .img-overflow img {
        height: 100%;
    }
    .share-list img {
        margin-right: 10px;
    }
    .share-list .img-overflow {
        overflow: hidden;
        height: 95px !important;
    }
    .share-list form button {
        margin-top: 0px !important;
        padding: 0px;
    }
    .share-list form input.btn-sm {
        height: 23px;
        padding: 0px;
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
</style> --}}
@endsection

@section('content')
<section class="share-list">
    <div class="container">
        <div class="row mb-4">
            <div class="col-6">
                <h3>Previously shared</h3>
            </div>
            <div class="col-6">
                <input class="w-100 form-control" type="text" placeholder="Search..." id="search_input">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 text-center">
                <textarea id="group-comment-1" style="height: 38px;vertical-align: middle;"></textarea>
                <a href="#" class="btn btn-success mr-2" onclick="send('group-comment-1')">Send</a>
                <a href="#" class="btn btn-danger" onclick="del()">Delete</a>
            </div>
        </div>
        @foreach ($shareListImgs as $share)
            <form action="{{ route('pre.shared.imgs') }}" method="post">
                @csrf
                <div class="row item share-item" data-text="{{ $share->comment ?? $share->created_at->format('d/m/Y H:i')}}">
                    <div class="col-md-4 mb-1 align-text-bottom">
                        <h6 class="font-weight-bold">
                            {{ $share->comment ?? $share->created_at->format('d/m/Y H:i')}}
                        </h6>
                        <input type="checkbox" class="mr-1" name="list" value="{{ $share->id }}"> @if ($share->comment)
                            {{ $share->created_at->format('d/m/Y H:i') }}
                        @endif
                        <a href="#" onclick="singleDelete({{ $share->id }})">Delete</a>
                        <a href="#" class="edit" onclick="$('#comment_{{ $share->id }}').show(); return false;">
                            <img src="{{ asset('assets/logos/pencil.svg') }}">
                        </a>
                        <textarea name="comment" style="display: none" id="comment_{{ $share->id }}" class="comment">{{ $share->comment }}</textarea>
                        
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="img-overflow gallery">
                            @foreach ($share->photos as $photo)
                                <a href="{{ asset($photo->image) }}" style="margin-right: .5em;">
                                    <img src="{{ asset($photo->image) }}" data-file="{{ asset($photo->image) }}">
                                </a>
                            @endforeach 
                        </div>
                    </div>
                    <div class="col-md-1">
                        <input type="hidden" name="hash" value="{{ $share->id }}"/>
                        <button class="btn btn-block font-weight-bold log_btn btn-sm mb-1"  name="action" value="share">Share</button>
                    </div>
            
                    <div class="col-md-2">
                        <button class="btn btn-block font-weight-bold log_btn btn-sm mb-1 download">Download</button>
                    </div>
            
                    <div class="col-md-1">
                        <button class="btn btn-block font-weight-bold log_btn btn-sm mb-1" name="action" value="url">URL</button>
                    </div>
                </div>
            </form>
        @endforeach
        <div class="row mt-3">
            <div class="col-12 text-center">
                <textarea id="group-comment-2" style="height: 38px;vertical-align: middle;"></textarea>
                <a href="#" class="btn btn-success mr-2" onclick="send('group-comment-2')">Send</a>
                <a href="#" class="btn btn-danger" onclick="del()">Delete</a>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Magnific Popup core JS file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script>
    $(document).ready(function() {
        $('.gallery').each(function() { 
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

    function multiDownload(files) {
        files.forEach(file => {
            if (file) { // Check if file is not undefined or null
                const link = document.createElement('a');
                link.href = file;
                link.download = file.split('/').pop(); // Extract the file name safely
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                console.warn('Invalid file URL:', file);
            }
        });
    }


    $(function (){
        $('.item').each((i, item) => {
            let files = [];
            $(item).find('img').each((ii, img) => {
                const fileUrl = $(img).data('file');
                if (fileUrl) {
                    files.push(fileUrl);
                } else {
                    // console.warn('Missing data-file attribute on img:', img);
                }
            });

            // console.log('Files for item:', i, files);
            $(item).find('.download').click((e) => {
                e.preventDefault();
                multiDownload(files);
            });
        });
        $('#search_input').on('keyup', onSearchChange);
    });
    function onSearchChange(e) {
        let val = $(this).val();
        $('.share-item').each((i, e) => {
            let dataText = $(e).data('text');
            if (!val || (dataText && dataText.toLowerCase().includes(val.toLowerCase()))) {
                $(e).show();
            } else {
                $(e).find('input[type=checkbox]').prop('checked', false);
                $(e).hide();
            }
        });
    }

    function send(fieldId){
        let list = [];
        $('[name=list]:checked').each((i, e) => {
            list.push($(e).val());
        });
        let comment = $('#' + fieldId).val();
        if (list.length){
            console.log(list);
            $.ajax({
            url: '/merge-share-data',
            type: 'POST',
            data: {
                list: list,
                comment: comment,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.whatsappLink) {
                    window.location.href = response.whatsappLink;
                    window.location.reload();
                } else {
                    alert('Something went wrong!');
                }
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseText);
            }
        });
        }
    }

    function del(){
        let list = [];
        $('[name=list]:checked').each((i, e) => {
            list.push($(e).val());
        });
        if (list.length){
            // console.log(list);
            document.location.href = '{{ route('preImgs.shares.delete') }}?ids=' + list.join(',');
        }
    }
    function singleDelete(id) {
        console.log(id);
        document.location.href = '{{ route('preImgs.shares.delete') }}?ids=' + id;
    }
</script>
@endsection