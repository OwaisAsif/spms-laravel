@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/multi-select/multi-select.css') }}">
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
    </style> --}}
@endsection

@section('content')
    <form action="{{ route('update.ftod', $property->code) }}" method="post" enctype="multipart/form-data">
        @csrf
        
        <div class="mt-2">
            <div class="container">
                <div id="step-5">
                    <h3>FTOD</h3>
                    @php
                        $savedFacilities = explode(',', $property->facilities);
                        $savedTypes = explode(',', $property->types);
                        $savedDecorations = explode(',', $property->decorations);
                        $savedUsages = explode(',', $property->usage);

                        $others = json_decode($property->others, true);
                        $dates = json_decode($property->other_date, true);
                        $formats = json_decode($property->other_free_formate, true);
                    @endphp
                    <div class="row">
                        <div class="col-12">
                            <p class="m-0">Facilities</p>
                            <select name="facilities[]" multiple="multiple" id="facilitiesSelect">
                                @foreach($facilities as $facility)
                                    <option value="{{ $facility }}" 
                                            {{ in_array($facility, $savedFacilities) ? 'selected' : '' }}>
                                        {{ $facility }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="m-0 mt-3">Types</p>
                            <select name="types[]" multiple="multiple" id="typesSelect" data-parsley-multiple="types[]">
                                @foreach($types as $type)
                                    <option value="{{ $type }}" 
                                            {{ in_array($type, $savedTypes) ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="m-0 mt-3">Decoration</p>
                            <select id="decorationsSelect" name="decorations[]" multiple="multiple">
                                @foreach($decorations as $decoration)
                                    <option value="{{ $decoration }}" 
                                            {{ in_array($decoration, $savedDecorations) ? 'selected' : '' }}>
                                        {{ ucfirst($decoration) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p class="m-0 mt-3">Usage</p>
                            <select id="usageSelect" name="usage[]" multiple="multiple">
                                @foreach($usage as $use)
                                    <option value="{{ $use }}" 
                                            {{ in_array($use, $savedUsages) ? 'selected' : '' }}>
                                        {{ $use }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p class="mt-3">Youtube Links</p>
                    <div class="row">
                        <div class="col-12">
                            <label>L1</label>
                            <input id="link" type="text" class="form-control" name="yt_link_1" value="{{ $property->yt_link_1 }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label>L2</label>
                            <input type="text" class="form-control" name="yt_link_2" value="{{ $property->yt_link_2 }}">
                        </div>
                    </div>
                    <p class="mt-3">Options</p>
                    
                    <div class="row"> 
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="new_site新場" class="mt-2" name="options[0]" value="New site 新場" data-parsley-multiple="options" 
                                        {{ in_array("New site 新場", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="new_site新場">New site新場</label>
                                </div>
                                <div class="col-6" id="new_site新場_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="site_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('New site 新場', $others) ? $dates[array_search('New site 新場', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="site_free_formate" class="form-control mb-3">{{ isset($others) && in_array('New site 新場', $others) ? trim($formats[array_search('New site 新場', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="Bargain_筍盤" class="mt-2" name="options[1]" value="Bargain 筍盤" data-parsley-multiple="options" 
                                        {{ in_array("Bargain 筍盤", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="Bargain_筍盤">Bargain 筍盤</label>
                                </div>
                                <div class="col-6" id="Bargain_筍盤_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="bargain_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('Bargain 筍盤', $others) ? $dates[array_search('Bargain 筍盤', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="bargain_free_formate" class="form-control mb-3">{{ isset($others) && in_array('Bargain 筍盤', $others) ? trim($formats[array_search('Bargain 筍盤', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="Discounted_減價中" class="mt-2" name="options[2]" value="Discounted 減價中" data-parsley-multiple="options" 
                                        {{ in_array("Discounted 減價中", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="Discounted_減價中">Discounted 減價中</label>
                                </div>
                                <div class="col-6" id="Discounted_減價中_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="discounted_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('Discounted 減價中', $others) ? $dates[array_search('Discounted 減價中', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="discounted_free_formate" class="form-control mb-3">{{ isset($others) && in_array('Discounted 減價中', $others) ? trim($formats[array_search('Discounted 減價中', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="Recommend_推薦" class="mt-2" name="options[3]" value="Recommend 推薦" data-parsley-multiple="options" 
                                        {{ in_array("Recommend 推薦", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="Recommend_推薦">Recommend 推薦</label>
                                </div>
                                <div class="col-6" id="Recommend_推薦_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="recommend_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('Recommend 推薦', $others) ? $dates[array_search('Recommend 推薦', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="recommend_free_formate" class="form-control mb-3">{{ isset($others) && in_array('Recommend 推薦', $others) ? trim($formats[array_search('Recommend 推薦', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="ready_to_listing_就吉" class="mt-2" name="options[4]" value="Ready to listing 就吉" data-parsley-multiple="options" 
                                        {{ in_array("Ready to listing 就吉", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="ready_to_listing_就吉">Ready to listing 就吉</label>
                                </div>
                                <div class="col-6" id="ready_to_listing_就吉_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="listing_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('Ready to listing 就吉', $others) ? $dates[array_search('Ready to listing 就吉', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="listing_free_formate" class="form-control mb-3">{{ isset($others) && in_array('Ready to listing 就吉', $others) ? trim($formats[array_search('Ready to listing 就吉', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="new_released_剛吉" class="mt-2" name="options[5]" value="New Released 剛吉" data-parsley-multiple="options" 
                                        {{ in_array("New Released 剛吉", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="new_released_剛吉">New Released 剛吉</label>
                                </div>
                                <div class="col-6" id="new_released_剛吉_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="released_date" class="form-control mb-3"
                                        value="{{ isset($others) && in_array('New Released 剛吉', $others) ? $dates[array_search('New Released 剛吉', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="released_free_formate" class="form-control mb-3">{{ isset($others) && in_array('New Released 剛吉', $others) ? trim($formats[array_search('New Released 剛吉', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6">
                                    <input type="checkbox" id="rent" class="mt-2" name="options[6]" value="Rent Out 巳租" data-parsley-multiple="options" {{ in_array("Rent Out 巳租", $others) ? 'checked' : '' }}>
                                    <label class="font-weight-bold ml-1" for="rent">Rent Out 巳租</label>
                                </div>
                                <div class="col-6" id="rent_section" style="display: none;">
                                    <input type="date" name="option_date[]" id="rent_date" class="form-control mb-3" value="{{ isset($others) && in_array('Rent Out 巳租', $others) ? $dates[array_search('Rent Out 巳租', $others)] : '' }}">
                                    <textarea name="option_free_formate[]" id="rent_free_formate" class="form-control mb-3">{{ isset($others) && in_array('Rent Out 巳租', $others) ? trim($formats[array_search('Rent Out 巳租', $others)]) : '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-5"></div>
                    <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg last_sub">UPDATE</button>
                </div>
            </div>
        </div>
        <!-- </form> -->
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('assets/multi-select/multiselect.js') }}"></script>
    <script>
        $('select[multiple]').multiselect({
            columns: 1,
            placeholder: 'Select',
            search: true,
            searchOptions: {
                'default': 'Search'
            },
            selectAll: true
        });

        $(document).ready(function () {
            function toggleSection(checkboxId, sectionId) {
                if ($(checkboxId).prop('checked')) {
                    $(sectionId).show();
                } else {
                    $(sectionId).hide();
                    $(sectionId).find('input[type="date"]').val(''); // Clear date input
                    $(sectionId).find('textarea').val(''); // Clear text area
                }
            }

            // Initial state toggle
            toggleSection('#new_site新場', '#new_site新場_section');
            toggleSection('#Bargain_筍盤', '#Bargain_筍盤_section');
            toggleSection('#Discounted_減價中', '#Discounted_減價中_section');
            toggleSection('#Recommend_推薦', '#Recommend_推薦_section');
            toggleSection('#ready_to_listing_就吉', '#ready_to_listing_就吉_section');
            toggleSection('#new_released_剛吉', '#new_released_剛吉_section');
            toggleSection('#rent', '#rent_section');

            // Event listeners for checkbox changes
            $('#new_site新場').change(function () {
                toggleSection('#new_site新場', '#new_site新場_section');
            });

            $('#Bargain_筍盤').change(function () {
                toggleSection('#Bargain_筍盤', '#Bargain_筍盤_section');
            });

            $('#Discounted_減價中').change(function () {
                toggleSection('#Discounted_減價中', '#Discounted_減價中_section');
            });

            $('#Recommend_推薦').change(function () {
                toggleSection('#Recommend_推薦', '#Recommend_推薦_section');
            });

            $('#ready_to_listing_就吉').change(function () {
                toggleSection('#ready_to_listing_就吉', '#ready_to_listing_就吉_section');
            });

            $('#new_released_剛吉').change(function () {
                toggleSection('#new_released_剛吉', '#new_released_剛吉_section');
            });

            $('#rent').change(function () {
                toggleSection('#rent', '#rent_section');
            });
        });
    </script>
@endsection