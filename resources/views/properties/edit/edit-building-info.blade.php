@extends('layouts.app')

@section('styles')

{{-- <style>
    .log_btn {
        background-color: #05445E;
        transition: 0.7s;
        color: #fff;
    }
    .log_btn:hover {
        background-color: #189AB4;
        color: #fff;
    }
    .nav-link {
        display: block;
        padding: .5rem 1rem;
    }
    .list-group {
        height: 300px;
        background-color: skyblue;
        /* width: 200px; */
        overflow-y: scroll;
    }
</style> --}}
@endsection

@section('content')

<form action="{{ route('update.buildinginfo', $property->code) }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mt-2">
        <div class="container">
            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1" style="position: static; left: auto; display: block;">
                <h3>Building Info</h3>
                <div class="row">
                    <div class="col-6">
                        <label for="">Code</label>
                        <input type="text" class="form-control mb-3" placeholder="Code" id="code" name="code" required="" value="{{ $property->code }}" readonly>
                        <div id="outputC"></div>
                    </div>
                    <div class="col-6">
                        <label for="">District</label>
                        <select name="district" id="district" class="form-control mb-3" autocomplete="off">
                            <option selected disabled>District</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district }}" {{ $property->district == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                            {{-- <option value="yt 油塘" {{ $property->district == 'yt 油塘' ? 'selected' : '' }}>yt 油塘</option>
                            <option value="kt 觀塘" {{ $property->district == 'kt 觀塘' ? 'selected' : '' }}>kt 觀塘</option>
                            <option value="klb 九龍灣" {{ $property->district == 'klb 九龍灣' ? 'selected' : '' }}>klb 九龍灣</option>
                            <option value="spk 新浦崗" {{ $property->district == 'spk 新浦崗' ? 'selected' : '' }}>spk 新浦崗</option>
                            <option value="csw 長沙灣" {{ $property->district == 'csw 長沙灣' ? 'selected' : '' }}>csw 長沙灣</option>
                            <option value="lck 荔枝角" {{ $property->district == 'lck 荔枝角' ? 'selected' : '' }}>lck 荔枝角</option>
                            <option value="kc 葵涌" {{ $property->district == 'kc 葵涌' ? 'selected' : '' }}>kc 葵涌</option>
                            <option value="tw 荃灣" {{ $property->district == 'tw 荃灣' ? 'selected' : '' }}>tw 荃灣</option>
                            <option value="mk 旺角" {{ $property->district == 'mk 旺角' ? 'selected' : '' }}>mk 旺角</option>
                            <option value="tst 尖沙咀" {{ $property->district == 'tst 尖沙咀' ? 'selected' : '' }}>tst 尖沙咀</option>
                            <option value="tkw 土瓜灣" {{ $property->district == 'tkw 土瓜灣' ? 'selected' : '' }}>tkw 土瓜灣</option>
                            <option value="kat 啟德" {{ $property->district == 'kat 啟德' ? 'selected' : '' }}>kat 啟德</option>
                            <option value="hh 紅磡" {{ $property->district == 'hh 紅磡' ? 'selected' : '' }}>hh 紅磡</option>
                            <option value="tkt 大角咀" {{ $property->district == 'tkt 大角咀' ? 'selected' : '' }}>tkt 大角咀</option>
                            <option value="jd 佐敦" {{ $property->district == 'jd 佐敦' ? 'selected' : '' }}>jd 佐敦</option>
                            <option value="ft 火炭" {{ $property->district == 'ft 火炭' ? 'selected' : '' }}>ft 火炭</option>
                            <option value="st 沙田" {{ $property->district == 'st 沙田' ? 'selected' : '' }}>st 沙田</option>
                            <option value="tp 大埔" {{ $property->district == 'tp 大埔' ? 'selected' : '' }}>tp 大埔</option>
                            <option value="ss 上水" {{ $property->district == 'ss 上水' ? 'selected' : '' }}>ss 上水</option>
                            <option value="tm 屯門" {{ $property->district == 'tm 屯門' ? 'selected' : '' }}>tm 屯門</option>
                            <option value="yl 元朗" {{ $property->district == 'yl 元朗' ? 'selected' : '' }}>yl 元朗</option>
                            <option value="tko 將軍澳" {{ $property->district == 'tko 將軍澳' ? 'selected' : '' }}>tko 將軍澳</option>
                            <option value="ty 青衣" {{ $property->district == 'ty 青衣' ? 'selected' : '' }}>ty 青衣</option>
                            <option value="wch 黃竹坑" {{ $property->district == 'wch 黃竹坑' ? 'selected' : '' }}>wch 黃竹坑</option>
                            <option value="sw 上環" {{ $property->district == 'sw 上環' ? 'selected' : '' }}>sw 上環</option>
                            <option value="ct 中環" {{ $property->district == 'ct 中環' ? 'selected' : '' }}>ct 中環</option>
                            <option value="wc 灣仔" {{ $property->district == 'wc 灣仔' ? 'selected' : '' }}>wc 灣仔</option>
                            <option value="cwb 銅鑼灣" {{ $property->district == 'cwb 銅鑼灣' ? 'selected' : '' }}>cwb 銅鑼灣</option>
                            <option value="np 北角" {{ $property->district == 'np 北角' ? 'selected' : '' }}>np 北角</option>
                            <option value="qb 鰂魚涌" {{ $property->district == 'qb 鰂魚涌' ? 'selected' : '' }}>qb 鰂魚涌</option>
                            <option value="skw 筲箕灣" {{ $property->district == 'skw 筲箕灣' ? 'selected' : '' }}>skw 筲箕灣</option>
                            <option value="cw 柴灣" {{ $property->district == 'cw 柴灣' ? 'selected' : '' }}>cw 柴灣</option>
                            <option value="ssw 小西灣" {{ $property->district == 'ssw 小西灣' ? 'selected' : '' }}>ssw 小西灣</option> --}}
                        </select>
                    </div>
                </div>

                <div>
                    <label for="">Building</label>
                    <input type="text" id="building" class="form-control mb-3" placeholder="Building name" name="building" autocomplete="off" required="" value="{{ $property->building }}">
                    <div id="outputB" class=""></div>
                </div>
                <div>
                    <label for="">Address</label>
                    <input type="text" id="address" class="form-control mb-3" placeholder="Address" name="street" value="{{ $property->street }}">
                </div>
                <div>
                    <label for="">Year</label>
                    <input type="text" id="year" class="form-control mb-3" placeholder="Year" name="year" value="{{ $property->year }}">
                </div>


                <div class="row">
                    <div class="col-6">
                        <label for="">Block</label>
                        <input type="text" class="form-control mb-3" placeholder="Block" name="block" autocomplete="off" value="{{ $property->block }}">
                    </div>
                    <div class="col-6">
                        <label for="">Floor</label>
                        <input type="text" class="form-control mb-3" placeholder="Floor" name="floor" autocomplete="off" value="{{ $property->floor }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Flat</label>
                        <input type="text" class="form-control mb-3" placeholder="Flat" name="flat" autocomplete="off" value="{{ $property->flat }}">
                    </div>
                    <div class="col-6">
                        <label for="">Room Number</label>
                        <input type="number" class="form-control mb-3" placeholder="No of Rooms" name="no_rooms" id="no_rooms" value="{{ $property->no_room }}">
                    </div>
                </div>
                <div class="mt-2 mb-1">
                    <p class="mb-0">Room Display By</p>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline1" name="display" class="custom-control-input" value="alp" data-parsley-multiple="display" {{ $property->display_by == 'alp' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customRadioInline1">A,B,C,D...</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="customRadioInline2" name="display" class="custom-control-input" value="num" data-parsley-multiple="display" {{ $property->display_by == 'num' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customRadioInline2">1,2,3,4...</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="">Cargo Lift</label>
                        <input type="text" class="form-control mb-3" placeholder="Cargo Lift" name="cargo_lift" id="cargo_lift" value="{{ $property->cargo_lift }}">
                    </div>
                    <div class="col-6">
                        <label for="">Customer Lift</label>
                        <input type="text" class="form-control mb-3" placeholder="Customer Lift" name="customer_lift" id="customer_lift" value="{{ $property->customer_lift }}">
                    </div>
                    <div class="col-6">
                        <label for="" class="d-block">24 hour</label>
                        <select id="" name="tf_hr" class="form-control mb-4">

                            <option value="Yes" {{ $property->tf_hr == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ $property->tf_hr == 'No' ? 'selected' : '' }}>No</option>
                        </select>

                    </div>
                    <div class="col-6 mb-4">
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="individual" value="Yes" id="exampleCheck1" data-parsley-multiple="individual" {{ $property->individual == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck1">Individual</label>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="separate" value="Yes" id="exampleCheck2" data-parsley-multiple="separate" {{ $property->separate == 'Yes' ? 'checked' : '' }}>
                            <label class="form-check-label" for="exampleCheck2">Separate</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="">Car Park</label>
                        <input type="text" class="form-control mb-3" placeholder="Car Park" name="car_park" id="car_park" autocomplete="off" value="{{ $property->car_park }}">
                    </div>
                    <div class="col-6">
                        <label for="">Number of Floors</label>
                        <input type="number" class="form-control mb-3" placeholder="Number of Floors" name="num_floors" id="num_floors" value="{{ $property->num_floors }}">
                    </div>
                    <div class="col-6">
                        <label for="">Ceiling height</label>
                        <input type="text" class="form-control mb-3" placeholder="Ceiling height" name="ceiling_height" 
                        id="ceiling_height" autocomplete="off" value="{{ $property->ceiling_height }}">
                    </div>
                    <div class="col-6">
                        <label for="">Air Conditioning System</label>
                        <input type="text" class="form-control mb-3" placeholder="Air Conditioning System" name="air_con_system" id="air_con_system" value="{{ $property->air_con_system }}">
                    </div>
                    <div class="col-6">
                        <label for="">Building Loading</label>
                        <input type="text" class="form-control mb-3" placeholder="Building Loading" name="building_loading" id="building_loading" autocomplete="off" value="{{ $property->building_loading }}">
                    </div>

                    <div class="col-12 mb-2">
                        <label for="">Enter Password</label>
                        <input type="text" class="form-control mb-2" placeholder="Entry Password" name="entry_password" value="{{ $property->enter_password }}">
                    </div>
                    <div class="col-12 mb-2">
                        <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3" placeholder="Admin Comment"></textarea>
                    </div>
                    <div class="col-12 mb-2">
                        <textarea name="admin_comment" class="form-control" id="" cols="30" rows="3" placeholder="Admin Comment" readonly=""></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">UPDATE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- </form> -->
</form>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#code').keyup(function() {
            let code = $(this).val();
            if (code != '') {
                $.ajax({
                    type: "POST",
                    url: "/check-code",
                    data: {
                        code: code,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "html",
                    success: function(data) {
                        $('#outputC').fadeIn();
                        $('#outputC').html(data);
                    }
                });
            } else {
                $('#outputC').fadeOut();
                $('#outputC').html("");
            }
        });

        $('#outputC').parent().on('click', 'li', function() {
            $('#code').val($(this).text());
            $('#outputC').fadeOut();
        });
    });

    $(document).ready(function() {
        $('#building').keyup(function () {
            let building = $(this).val();
            if (building !== '') {
                $.ajax({
                    type: "POST",
                    url: "{{ route('search.building') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        building: building
                    },
                    success: function (data) {
                        $('#outputB').fadeIn();
                        $('#outputB').html(data);
                    }
                });
            } else {
                $('#outputB').fadeOut();
                $('#outputB').html("");
            }
        });

        $('#outputB').parent().on('click', 'li', function() {
            let text1 = $(this).text();
            $('#building').val(text1);
            $.ajax({
                type: "POST",
                url: "{{ route('get.building.info') }}", 
                data: {
                    _token: '{{ csrf_token() }}',
                    text1: text1
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data);
                    if (data.address_chinese) {
                        $('#address').val(data.address_chinese);
                    }
                    if (data.year) {
                        $('#year').val(data.year);
                    }
                    if(data.propertyLatest.num_floors){
                        $('#num_floors').val(data.propertyLatest.num_floors);
                    }
                    if(data.propertyLatest.ceiling_height){
                        $('#ceiling_height').val(data.propertyLatest.ceiling_height);
                    }
                    if(data.propertyLatest.air_con_system){
                        $('#air_con_system').val(data.propertyLatest.air_con_system);
                    }
                    if(data.propertyLatest.building_loading){
                        $('#building_loading').val(data.propertyLatest.building_loading);
                    }
                    if(data.propertyLatest.car_park){
                        $('#car_park').val(data.propertyLatest.car_park);
                    }
                    if(data.propertyLatest.customer_lift){
                        $('#customer_lift').val(data.propertyLatest.customer_lift);
                    }
                    if(data.propertyLatest.cargo_lift){
                        $('#cargo_lift').val(data.propertyLatest.cargo_lift);
                    }
                },
                error: function() {
                    console.error('Building not found or error occurred');
                }
            });

            // Hide the dropdown after selection
            $('#outputB').fadeOut();
        });
    });
</script>
@endsection