@extends('layouts.app')

@section('styles')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}

<link rel="stylesheet" href="{{ asset('assets/multi-select/multi-select.css') }}">
<link rel="stylesheet" href="{{ asset('assets/parsley-plugin/style.css') }}">
{{-- <style>
    body {
        font-size: 12px !important;
    }
    p {
        font-size: 20px;
        margin-bottom: 0;
    }
    td {
        padding: 8px !important;
    }
    #search-table thead {
        background-color: #f5f5f5 !important;
    }
    #search-table tbody tr:hover {
        background-color: #f5f5f5 !important;
    }
    #search-table th, #search-table td {
        text-align: center;
        vertical-align: middle;
    }
    table.dataTable {
        border-collapse: collapse !important;
    }
    .form-check-width {
        width: 50%;
    }
</style> --}}
@endsection

@section('content')
<section>
    <div class="container bg-white pr-4 pl-4  log_section pb-5 pt-lg-4">
        <h4 class="font-weight-bold ">Landlord Information</h4>
        <form id="admin-search-form" method="GET" data-parsley-validate>
            @csrf
            <div class="row">
                <div class="col-3">
                    <input type="checkbox" id="rent" class="mt-2" name="types1[]" value="Rent 放租">
                    <label class="font-weight-bold ml-1" for="rent">Rent 放租</label>

                </div>

                <div class="col-3">
                    <input type="checkbox" id="sell" class="mt-2" name="types1[]" value="Sales 放售">
                    <label class="font-weight-bold ml-1" for="sell">Sales 放售</label>
                </div>

                <div class="col-3">
                    <input type="checkbox" id="independent" class="mt-2" name="types1[]" value="Independent 獨立單位">
                    <label class="font-weight-bold ml-1" for="independent">Independent 獨立單位</label>

                </div>

                <div class="col-3">
                    <input type="checkbox" id="subdivided" class="mt-2" name="types1[]" value="Subdivided 分間">
                    <label class="font-weight-bold ml-1" for="subdivided">Subdivided 分間</label>

                </div>
            </div>    
            <div class="row">
                <div class="col-7">
                    <input class="form-control mr-sm-2 mb-3" name="info" id="info" type="text" placeholder="Enter Building Name or Keyword">
                </div>
                <div class="col-5">
                    <select name="district" id="district" class="form-control" placeholder="District">
                        <option value="All" selected="">All</option> 
                        @foreach ($districts as $district)
                            <option value="{{ $district }}">
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-12">
                    <p class="m-0">Facilities</p>
                    <select name="facilities[]" multiple="multiple" id="facilitiesSelect">
                        @foreach ($facilities as $facility)
                            <option value="{{ $facility }}">
                                {{ $facility }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <p class="m-0">Types</p>
                    <select name="types[]" multiple="multiple" id="typesSelect" data-parsley-multiple="types[]">
                        @foreach ($types as $type)
                            <option value="{{ $type }}">
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <p class="m-0">Decoration</p>
                    <select id="decorationsSelect" name="decorations[]" multiple="multiple">
                        @foreach ($decorations as $decoration)
                            <option value="{{ $decoration }}">
                                {{ ucfirst($decoration) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <p class="m-0">Usage 用途</p>
                    <select id="usageSelect" name="usage[]" multiple="multiple">
                        @foreach ($usage as $use)
                            <option value="{{ $use }}">
                                {{ $use }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <p class="mt-3">Options</p>
            <div class="row">
                <div class="col-6">
                    <input type="checkbox" id="new_site新場" class="mt-2" name="options[]" value="New site 新場">
                    <label class="font-weight-bold ml-1" for="new_site新場">New site新場</label>

                </div>

                <div class="col-6">
                    <input type="checkbox" id="Bargain_筍盤" class="mt-2" name="options[]" value="Bargain 筍盤">
                    <label class="font-weight-bold ml-1" for="Bargain_筍盤">Bargain 筍盤</label>

                </div>

                <div class="col-6">
                    <input type="checkbox" id="Discounted_減價中" class="mt-2" name="options[]" value="Discounted 減價中">
                    <label class="font-weight-bold ml-1" for="Discounted_減價中">Discounted
                        減價中</label>

                </div>

                <div class="col-6">
                    <input type="checkbox" id="Recommend_推薦" class="mt-2" name="options[]" value="Recommend 推薦">
                    <label class="font-weight-bold ml-1" for="Recommend_推薦">Recommend 推薦</label>

                </div>

                <div class="col-6">
                    <input type="checkbox" id="ready_to_listing_就吉" class="mt-2" name="options[]" value="Ready to listing 就吉">
                    <label class="font-weight-bold ml-1" for="ready_to_listing_就吉">Ready to
                        listing 就吉</label>

                </div>
                <div class="col-6">
                    <input type="checkbox" id="new_released_剛吉" class="mt-2" name="options[]" value="New Released 剛吉">
                    <label class="font-weight-bold ml-1" for="new_released_剛吉">New
                        Released 剛吉</label>

                </div>
                
                <div class="col-6">
                    <input type="checkbox" id="rent_out" class="mt-2" name="options[]" value="Rent Out 巳租">
                    <label class="font-weight-bold ml-1" for="rent_out">Rent Out 巳租</label>
                </div>
            </div>

            <div class="text-right">
                <button class="btn btn-primary mb-1" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Price &amp; Size
                </button>
            </div>
            <br>
            <div class="collapse mb-1" id="collapseExample">
                <div class="card card-body">
                    <div class="row">
                        <div class="col-12">
                            <p style="font-size: 14px; white-space: nowrap;" class="font-weight-bold display-6 ">
                                Gross 建呎
                            </p>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="gross_from" placeholder="From" class="form-control ">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="gross_to" placeholder="To" class="form-control ">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p style="font-size: 14px; white-space: nowrap;" class="font-weight-bold display-6 ">Net 實呎
                            </p>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="net_from" placeholder="From" class="form-control ">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="net_to" placeholder="To" class="form-control ">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p style="font-size: 14px; white-space: nowrap;" class="font-weight-bold display-6 ">
                                Selling 售價(百萬)
                            </p>
                        </div>
                        <div class="col-6">
                            <input type="number" name="selling_from" step="0.01" placeholder="From" class="form-control ">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="selling_to" placeholder="To" class="form-control ">
                        </div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-12">
                            <p style="font-size: 14px; white-space: nowrap;" class="font-weight-bold display-6 ">
                                Rental 租金
                            </p>
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="rental_from" placeholder="From" class="form-control ">
                        </div>
                        <div class="col-6">
                            <input type="number" step="0.01" name="rental_to" placeholder="To" class="form-control ">
                        </div>
                    </div>
                </div>
            </div>
            <!-- This is size price  -->

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="search">Search</button>
            <a class="btn btn-outline-danger my-2 my-sm-0" id="clearBtn" href="#">Clear</a>
            
        </form>

        <div class="row">
            <div class="col-md-6">
                <p id="results" style="display:none;">
                    <strong>
                        Results: <span id="counter"></span>
                    </strong>
                </p>
            </div>
            <div class="col-md-6">
                <button class="btn btn-outline-info my-2 my-sm-0" id="toggle_layout" style="float:right;display:none;">More</button>
                <button class="btn btn-outline-info my-2 my-sm-0 mx-1" id="makeExcel" data-toggle="modal" data-target="#columnModal" style="float:right;display:none">Export as Excel</button>
                <button class="btn btn-outline-info my-2 my-sm-0" id="mark" style="float:right;display:none">Mark</button>
                <button class="btn btn-outline-success my-2 my-sm-0 mx-1" id="simple_layout" style="float:right;display:none;">檢視</button>
            </div>
        </div>

        <div id="output2" class="mt-4">
            <div id="main_layout" style="display:none;">
            </div>
            <div id="simple_layout_div" style="display: none;">
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <table class="table table-bordered dataTable no-footer" id="search-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 13px;">
                                    <input onchange="getAllRowIds(this)" id="selectAll" type="checkbox">
                                </th>
                                <th>Code</th>
                                <th>Floor</th>
                                <th>Flat</th>
                                <th>Block</th>
                                <th>Gross sf</th>
                                <th>Net sf</th>
                                <th>Rental Price</th>
                                <th>G@</th>
                                <th>N@</th>
                                <th>Sell Price (M)</th>
                                <th>G@</th>
                                <th>N@</th>
                                <th>District</th>
                                <th>Total Pics</th>
                                <th style="width: 500px !important;">Other</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>        

    </div>

    <div class="modal fade" id="columnModal" tabindex="-1" role="dialog" aria-labelledby="columnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="columnModalLabel">Select Columns</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body row px-5" id="checkboxContainer">
                    <div style="width: 100%">
                        <input checked="" type="checkbox" id="checkbox-all-columns"><label for="checkbox-all-columns">全選</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="大廈" value="building" id="checkbox-Building"><label for="checkbox-Building">大廈</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="街道" value="street" id="checkbox-Street"><label for="checkbox-Street">街道</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="地區" value="district" id="checkbox-District"><label for="checkbox-District">地區</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="樓層" value="floor" id="checkbox-Floor"><label for="checkbox-Floor">樓層</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="單位" value="flat" id="checkbox-Flat"><label for="checkbox-Flat">單位</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="座數" value="block" id="checkbox-Block"><label for="checkbox-Block">座數</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="業主叫租" value="rental_price" id="checkbox-Rental_price"><label for="checkbox-Rental_price">業主叫租</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="呎租(建)" value="rental_g" id="checkbox-Rental_g"><label for="checkbox-Rental_g">呎租(建)</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="呎租(實)" value="rental_n" id="checkbox-Rental_n"><label for="checkbox-Rental_n">呎租(實)</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="售價" value="selling_price" id="checkbox-selling_price"><label for="checkbox-selling_price">售價</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="呎價(建)" value="selling_g" id="checkbox-selling_g"><label for="checkbox-selling_g">呎價(建)</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="呎價(建)" value="selling_n" id="checkbox-selling_n"><label for="checkbox-selling_n">呎價(實)</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="建築面積" value="gross_sf" id="checkbox-Gross_sf"><label for="checkbox-Gross_sf">建築面積</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="實用面積" value="net_sf" id="checkbox-Net_sf"><label for="checkbox-Net_sf">實用面積</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="管理費" value="mgmf" id="checkbox-MGMF"><label for="checkbox-MGMF">管理費</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="差餉" value="rate" id="checkbox-Rate"><label for="checkbox-Rate">差餉</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="地租" value="land" id="checkbox-Land"><label for="checkbox-Land">地租</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="其他" value="oths" id="checkbox-Oths"><label for="checkbox-Oths">其他</label>
                    </div>
                    {{-- <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="聯絡人" value="contacts" id="checkbox-contacts"><label for="checkbox-contacts">聯絡人</label>
                    </div> --}}
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="圖片" value="image" id="checkbox-Image"><label for="checkbox-Image">圖片</label>
                    </div>
                    <div class="form-check-width">
                        <input checked="" type="checkbox" data-name="Code" value="code" id="checkbox-Code"><label for="checkbox-Code">Code</label>
                    </div>
                </div>
                <div class="d-flex justify-content-end p-4">
                    <button type="button" class="btn btn-secondary mx-1" data-dismiss="modal">Close</button>
                    <button type="button" id="downloadExcel" class="btn btn-primary">Download file</button>
                </div>
                <p id="colerror"></p>
            </div>
        </div>
    </div>

<div id="test"></div>
</section>
@endsection

@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script src="{{ asset('assets/multi-select/multiselect.js') }}"></script>
<script src="{{ asset('assets/parsley-plugin/script.js') }}"></script>

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
    $('#clearBtn').on('click', function(e) {
        e.preventDefault();
        location.reload();
    });
    $('#simple_layout').click(function() {
        $('#main_layout').toggle();
        $('#simple_layout_div').toggle();
        $('#toggle_layout').toggle();
        $('#toggle_layout').click();
    });

    $(document).ready(function () {
        $('#admin-search-form').on('submit', function (e) {
            e.preventDefault();
            // console.log('hh');
            // var info = $('input[name="info"]').val();
            // var district = $('input[name="district"]').val();
            // var grossFrom = $('input[name="gross_from"]').val();
            // var grossTo = $('input[name="gross_to"]').val();
            // var netFrom = $('input[name="net_from"]').val();
            // var netTo = $('input[name="net_to"]').val();
            // var sellingFrom = $('input[name="selling_from"]').val();
            // var sellingTo = $('input[name="selling_to"]').val();
            // var rentalFrom = $('input[name="rental_from"]').val();
            // var rentalTo = $('input[name="rental_to"]').val();

            // // Check if all values are either empty or 0
            // if (district === 'All' && !grossFrom && !grossTo && !netFrom && !netTo && !sellingFrom && !sellingTo && !rentalFrom && !rentalTo) {
            //     return;
            // }
            var form = $(this);
            form.find(":input").each(function () {
                if ($(this).val() === "" || $(this).val() === null) {
                    $(this).attr("disabled", "disabled");
                }
            });

            var formData = $(this).serialize();
            // console.log(formData);
            $.ajax({
                url: "{{ route('admin.search.result') }}", 
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    form.find(":input").prop("disabled", false);
                    console.log(response);
                    const count = response.count;
                    $('#counter').text(count);
                    
                    $('#results').show();
                    $('#main_layout').empty();

                    $('#main_layout').hide();
                    $('#simple_layout_div').hide();
                    $('#toggle_layout').hide();
                    
                    if (count > 0) {
                        $('#simple_layout').show();

                        $.each(response.data, function(index, item) {
                            const photosCount = item.photos.length;

                            var createdAt = new Date(item.created_at);
                            var formattedDate = createdAt.getFullYear() + '/' +
                            ('0' + (createdAt.getMonth() + 1)).slice(-2) + '/' +
                            ('0' + createdAt.getDate()).slice(-2);

                            var others = Array.isArray(item.others) ? item.others : (item.others ? JSON.parse(item.others) : []);
                            var dates = Array.isArray(item.other_date) ? item.other_date : (item.other_date ? JSON.parse(item.other_date) : []);
                            var currentDates = Array.isArray(item.other_current_date) ? item.other_current_date : (item.other_current_date ? JSON.parse(item.other_current_date) : []);
                            var formats = Array.isArray(item.other_free_formate) ? item.other_free_formate : (item.other_free_formate ? JSON.parse(item.other_free_formate) : []);

                            // var dateFormated = formatDate(dates[index] || '');
                            var today = new Date().setHours(0, 0, 0, 0); 
                            var otherHtml = '';
                            // if ($.isArray(others) && $.isArray(dates) && $.isArray(formats)) {
                            //     $.each(others, function(index, other) {
                            //         otherHtml += `
                            //             <p class="font-weight-bold" style="font-size:12px !important">
                            //                 <span class="text-dark">${other || ''}</span>
                            //                 <span class="text-success">(${dateFormated})</span>
                            //                 <span class="bg-primary text-white">(${formats[index] || ''})</span>
                            //                 <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                            //             </p>
                            //         `;
                            //     });
                            // }
                            if ($.isArray(others) && $.isArray(dates) && $.isArray(formats)) {
                                $.each(others, function(index, other) {
                                    var dateStr = dates[index] || '';
                                    var formattedDateStr = formatDate(dateStr);
                                    var parsedDate = new Date(dateStr).setHours(0, 0, 0, 0);

                                    if (dateStr && parsedDate >= today) {
                                        otherHtml += `
                                            <p class="font-weight-bold" style="font-size:12px !important">
                                                <span class="text-dark">${other || ''}</span>
                                                <span class="text-success">(${formattedDateStr})</span>
                                                <span class="bg-primary text-white">(${formats[index] || ''})</span>
                                                <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                                            </p>
                                        `;
                                    } else if (other === 'Rent Out 巳租') { 
                                        otherHtml += `
                                            <p class="font-weight-bold" style="font-size:12px !important">
                                                <span class="text-dark">${other || ''}</span>
                                                <span class="text-danger">(${formattedDateStr})</span>
                                                <span class="bg-primary text-white">(${formats[index] || ''})</span>
                                                <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                                            </p>
                                        `;
                                    }
                                });
                            }

                            // Handle the types array
                            var typesHtml = '';
                            if (item.types) {
                                const highlightedTypes = ['Rent 放租', 'Sales 放售', 'Independent 獨立單位', 'Subdivided 分間'];
                                const typesArray = item.types.split(',').map(type => type.trim());

                                typesHtml = typesArray.map((type, index) => {
                                    const divClass = highlightedTypes.includes(type) ? 'd-inline bg-warning' : 'd-inline';
                                    const separator = (index < typesArray.length - 1) ? ', ' : '';
                                    return `<div class="${divClass}">${type}${separator}</div>`;
                                }).join('');
                            }

                            const otherVisibilityStyle = others.length > 0 ? 'block' : 'none';
                            const grossSfHtml = item.gross_sf != null
                                ? `<div class="d-inline"><strong>Gross sf:</strong> <span class="text-primary">${item.gross_sf}</span></div>
                                <hr class="m-1 w-50 text-center">`
                                : '';
                            const sellPriceHtml = item.selling_price != null
                                ? `<div class="d-block"><strong>Selling price (M):</strong> <span class="text-primary">${item.selling_price}</span></div>
                                    <div class="d-inline"><strong>G@:</strong> <span class="text-primary">${item.selling_g}</span></div>
                                    <hr class="m-1 w-50 text-center">`
                                : '';
                            const rentalPriceHtml = item.rental_price != null
                                ? `<div class="d-block"><strong>Rental price:</strong> <span class="text-primary">${item.rental_price}</span></div>
                                    <div class="d-inline"><strong>G@:</strong> <span class="text-primary">${item.rental_g}</span></div>
                                    <hr class="m-1 w-50 text-center">`
                                : '';
                            const othsHtml = item.oths != null
                                ? `<div class="d-inline"><strong>Oths:</strong> <span class="text-primary">${item.oths}</span></div>`
                                : '';

                            const htmlContent = `
                                <div class="bg-light mb-3 p-2 shadow-sm border rounded">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <a href="property/${item.code}" class="m-0" target="_blank">
                                                <strong>Code:</strong> ${item.code}
                                            </a>
                                            <div class="d-inline">[${item.agent_name}] [${formattedDate}] [Pics: ${photosCount}]</div><br>
                                            <div class="d-inline mr-2"><strong>Building:</strong> ${item.building}</div>
                                            <div class="d-inline mr-2"><strong>Floor:</strong> ${item.floor || ''}</div>
                                            <div class="d-inline mr-2"><strong>Flat:</strong> ${item.flat || ''}</div>
                                            <div class="d-inline mr-2"><strong>Block:</strong> ${item.block || ''}</div>
                                            <div class="d-inline mr-2"><strong>District:</strong> ${item.district || ''}</div>
                                            <hr class="m-1 bg-dark">
                                            <div class="d-inline"><strong>Facilities:</strong> ${item.facilities || ''}</div>
                                            <hr class="m-1 bg-dark">
                                            <div class="d-inline"><strong>Types:</strong> ${typesHtml}</div>
                                            <hr class="m-1 bg-dark">
                                            <div class="d-inline"><strong>Decorations:</strong> ${item.decorations || ''}</div>
                                            <hr class="m-1 bg-dark">
                                            <div class="d-inline"><strong>Usage:</strong> ${item.usage || ''}</div>
                                            <div style="display:${otherVisibilityStyle}">
                                                <hr class="m-1 bg-dark">
                                                <div class="d-inline"><strong>Other:</strong>
                                                    <button style="margin-right:5px;color:white;background-color:blue;cursor:pointer;" onclick="clearRo2(${item.building_id})">RL</button>
                                                    <button class="ro-btn" data-ro-id="${item.building_id}" style="margin-right:5px;color:white;background-color:red;cursor:pointer;" onclick="clearRo(${item.building_id},this)">RO</button>
                                                    <input type="date" class="d-none" id="date-input-${item.building_id}">
                                                </div>
                                                
                                                <div class="oter" id="other-${item.building_id}">
                                                    ${otherHtml}
                                                </div>
                                            </div>
                                            <hr class="m-1 bg-dark">
                                            ${grossSfHtml}
                                            ${sellPriceHtml}
                                            ${rentalPriceHtml}
                                            ${othsHtml}    
                                        </div>
                                        <div class="col-md-4">
                                            <img src="${item.photos.length ? item.photos[0].image : ''}" class="img-fluid w-100 mt-2">    
                                        </div>    
                                    </div>
                                    
                                </div>
                            `;
                            $('#main_layout').append(htmlContent);

                            // Check if "Rent Out 巳租" exists in the others array
                            if (others.some(item => item.includes("Rent Out 巳租"))) {
                                $(`.ro-btn[data-ro-id="${item.building_id}"]`).addClass("d-none");
                            } else {
                                $(`.ro-btn[data-ro-id="${item.building_id}"]`).removeClass("d-none");
                            }
                        });

                        const dynamicData = response.data;
                        
                        $('#search-table').DataTable({
                            destroy: true,
                            data: dynamicData,
                            lengthChange: false,
                            columns: [
                                {
                                    data: null,
                                    render: function(data, type, row) {
                                        return `<input type="checkbox" onchange="getSingleRow(this)" class="input-check share" data-share="listing-${row.code}" data-row-num="${row.building_id}">`;
                                    },
                                },
                                { data: 'code', render: function(data) { return `<a target="_blank" href="property/${data}">${data}</a>`; } },
                                { data: 'floor' },
                                { data: 'flat' },
                                { data: 'block' },
                                { data: 'gross_sf' },
                                { data: 'net_sf' },
                                {
                                    data: 'rental_price',
                                    render: function(data) {
                                        if (data !== null && !isNaN(data)) {
                                            return `<span style="color:blue">${data.toFixed(2)}</span>`;
                                        }
                                        return `<span style="color:blue">0.00</span>`;
                                    }
                                },
                                { data: 'rental_g' },
                                { data: 'rental_n' },
                                {
                                    data: 'selling_price',
                                    render: function(data) {
                                        if (data !== null && !isNaN(data)) {
                                            return `<span style="color:blue">${data.toFixed(2)}</span>`;
                                        }
                                        return '<span style="color:blue">0.00</span>';
                                    }
                                },
                                { data: 'selling_g' },
                                { data: 'selling_n' },
                                { data: 'district' },
                                {
                                    data: 'photos',
                                    render: function(data) {
                                        return data ? data.length : 0;
                                    }
                                },
                                {
                                    data: null,
                                    render: function(data, type, row) {
                                        // Parse the data fields to arrays
                                        var others = Array.isArray(row.others) ? row.others : (row.others ? JSON.parse(row.others) : []);
                                        var dates = Array.isArray(row.other_date) ? row.other_date : (row.other_date ? JSON.parse(row.other_date) : []);
                                        var currentDates = Array.isArray(row.other_current_date) ? row.other_current_date : (row.other_current_date ? JSON.parse(row.other_current_date) : []);
                                        var formats = Array.isArray(row.other_free_formate) ? row.other_free_formate : (row.other_free_formate ? JSON.parse(row.other_free_formate) : []);

                                        var today = new Date().setHours(0, 0, 0, 0);
                                        var otherHtml = '';
                                        // Check if there is data in others, dates, and formats, then generate the HTML
                                        // if ($.isArray(others) && $.isArray(dates) && $.isArray(formats)) {
                                        //     $.each(others, function(index, other) {
                                        //         var dateFormated = formatDate(dates[index] || '');
                                        //         otherHtml += `
                                        //             <p class="font-weight-bold" style="font-size:12px !important">
                                        //                 <span class="text-dark">${other || ''}</span>
                                        //                 <span class="text-success">(${dateFormated})</span>
                                        //                 <span class="bg-primary text-white">(${formats[index] || ''})</span>
                                        //                 <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                                        //             </p>
                                        //         `;
                                        //     });
                                        // }
                                        if ($.isArray(others) && $.isArray(dates) && $.isArray(formats)) {
                                            $.each(others, function(index, other) {
                                                var dateStr = dates[index] || '';
                                                var formattedDateStr = formatDate(dateStr);
                                                var parsedDate = new Date(dateStr).setHours(0, 0, 0, 0);

                                                if (dateStr && parsedDate >= today) {
                                                    otherHtml += `
                                                        <p class="font-weight-bold" style="font-size:12px !important">
                                                            <span class="text-dark">${other || ''}</span>
                                                            <span class="text-success">(${formattedDateStr})</span>
                                                            <span class="bg-primary text-white">(${formats[index] || ''})</span>
                                                            <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                                                        </p>
                                                    `;
                                                } else if (other === 'Rent Out 巳租') { 
                                                    otherHtml += `
                                                        <p class="font-weight-bold" style="font-size:12px !important">
                                                            <span class="text-dark">${other || ''}</span>
                                                            <span class="text-danger">(${formattedDateStr})</span>
                                                            <span class="bg-primary text-white">(${formats[index] || ''})</span>
                                                            <span class="bg-dark text-white" style="margin-left: 5px">(${currentDates[index] || ''})</span>
                                                        </p>
                                                    `;
                                                }
                                            });
                                        }

                                        // Only return the HTML if there is any content in `otherHtml`
                                        if (otherHtml) {
                                            return `
                                                <td style="width:500px !important;">
                                                    <hr class="m-1 bg-dark decorations open">
                                                    <div class="mr-2 d-inline">
                                                        <b>Other:
                                                            <button style="margin-right:5px;color:white;background-color:blue;cursor:pointer;" onclick="clearRo2(${row.building_id})">RL</button>
                                                            <button class="ro-btn" data-ro-id="${row.building_id}" style="margin-right:5px;color:white;background-color:red;cursor:pointer;" onclick="clearRoTable(${row.building_id},this)">RO</button>
                                                            <input type="date" class="d-none" id="date-table-${row.building_id}">
                                                        </b>
                                                        <div class="oter" id="otherT-${row.building_id}">
                                                            ${otherHtml}
                                                        </div>
                                                    </div>
                                                </td>
                                            `;
                                        }

                                        // Return an empty string if there is no data to show
                                        return '';
                                    }
                                }
                            ],
                            columnDefs: [
                                {
                                    targets: -1,
                                    className: 'dt-left',
                                    width: '100%'
                                }
                            ],
                            responsive: true,
                            drawCallback: function() {
                                $('#search-table tbody tr').each(function() {
                                    var row = $(this);
                                    var rowData = $('#search-table').DataTable().row(row).data();

                                    if (rowData) {
                                        var others = Array.isArray(rowData.others) ? rowData.others : (rowData.others ? JSON.parse(rowData.others) : []);
                                        if (others.some(text => text.includes("Rent Out 巳租"))) {
                                            row.find(`.ro-btn[data-ro-id="${rowData.building_id}"]`).addClass("d-none");
                                        } else {
                                            row.find(`.ro-btn[data-ro-id="${rowData.building_id}"]`).removeClass("d-none");
                                        }
                                    }
                                });
                            }
                        });
                        
                        $('#main_layout').show();
                    }
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('An error occurred while processing the request.');
                }
            });
        });
    });

    function formatDate(date) {
        var d = new Date(date);
        var day = ("0" + d.getDate()).slice(-2);
        var month = ("0" + (d.getMonth() + 1)).slice(-2);
        var year = d.getFullYear();

        return day + '-' + month + '-' + year;
    }

    function clearRo(b_id){
        $('#date-input-'+b_id).on('input', function(e) {
            // console.log(e.target.value)
            RunclearRo(b_id,e.target.value)
        })
        $('#date-input-'+b_id).toggleClass('d-none')
    }

    function clearRoTable(b_id){
        $('#date-table-'+b_id).on('input', function(e) {
            // console.log(e.target.value)
            RunclearRo(b_id,e.target.value)
        })
        $('#date-table-'+b_id).toggleClass('d-none')
    }

    function RunclearRo(b_id, date) {
        let formData = new FormData();
        formData.append("building_id", b_id);
        formData.append("date", formatDate(new Date(date)));

        $.ajax({
            type: "POST",
            url: "{{ route('ftod.others.ro') }}",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                if (response) {
                    let html = `
                        <p class="font-weight-bold" style="font-size:12px !important">
                            <span class="text-dark">Rent Out 巳租</span>
                            <span class="text-success">${formatDate(new Date(date))}</span>
                            <span style="background-color:blue;color:white;">( )</span>
                        </p>
                    `;
                    // console.log($('#other-' + b_id), html);
                    // Remove button
                    // $('button[onclick="clearRo2('+b_id+')"]').remove();
                    $('button[data-ro-id="' + b_id + '"]').remove();
                    $('#date-input-' + b_id).remove();

                    $('#other-' + b_id).empty();
                    $('#other-' + b_id).append(html);

                    $('#otherT-' + b_id).empty();
                    $('#otherT-' + b_id).append(html);
                } else {
                    // Handle no data scenario
                    console.log('No data returned.');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ', error);
                console.log('Status: ', status);
                console.log('Response Text: ', xhr.responseText);
            }
        });
    }

    function clearRo2(b_id) {
        $.ajax({
            url: "{{ route('ftod.others', ':id') }}".replace(':id', b_id),
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response) {
                    let html = `
                    <p class="font-weight-bold" style="font-size:12px !important">
                        <span class="text-dark">Rent Out 巳租</span>
                        <span class="text-success">${getCurrentDate()}</span>
                        <span style="background-color:blue;color:white;"> ( ) </span>
                    </p>
                    `;
                    
                    // Remove button
                    $('button[onclick="clearRo2('+b_id+')"]').remove();
                    $('button[data-ro-id="' + b_id + '"]').remove();
                    $('#date-input-' + b_id).remove();
                    
                    // Update the content
                    let target = $('#other-'+b_id);
                    let target2 = $('#otherT-'+b_id);
                    if (target.length) {
                        target.empty();
                        // target.empty().append(html);
                    }
                    if (target2.length) {
                        target2.empty();
                        // target.empty().append(html);
                    }
                } else {
                    console.log("No Data");
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong!");
            }
        });
    }

    // Function to get the current date in YYYY-MM-DD format
    function getCurrentDate() {
        let today = new Date();
        return today.getFullYear() + '-' + 
            String(today.getMonth() + 1).padStart(2, '0') + '-' + 
            String(today.getDate()).padStart(2, '0');
    }
    
    $(document).ready(function () {
        let table;
        $("#simple_layout").on('click', function () {
            if (!$.fn.DataTable.isDataTable('#search-table')) {
                table = $('#search-table').DataTable({
                    responsive: false,
                    pageLength: 50,
                    stateSave: true,
                    dom: 'Bfrtip',
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ]
                });
                setInitialColumnVisibility();
            }
        });

        $('#toggle_layout').on('click', function () {
            if ($.fn.DataTable.isDataTable('#search-table')) {
                table = $('#search-table').DataTable();
                table.columns([12, 6, 9, 4]).visible(!table.column(12).visible());
            } else {
                console.warn("Table not initialized yet!");
            }
        });

        function setInitialColumnVisibility() {
            table.column(0).visible(true);
            table.column(1).visible(true);
            table.column(2).visible(true);
            table.column(3).visible(true);
            table.column(5).visible(true);
            table.column(7).visible(true);
            table.column(8).visible(true);
            table.column(10).visible(true);
            table.column(11).visible(true);
            table.column(13).visible(true);

            table.column(4).visible(false);
            table.column(6).visible(false);
            table.column(9).visible(false);
            table.column(12).visible(false);
        }
    });

    let selectedIds = [];
    function getAllRowIds(checkbox) {
        const allRowIds = [];
        console.log(checkbox.checked);
        if (checkbox.checked) {
            $('.input-check').prop('checked', false);
            for (let i = 0; i < 51; i++) {
                const $inputCheck = $('.input-check').eq(i);
                $inputCheck.prop('checked', true);
                allRowIds.push($inputCheck.data('row-num'));
            }
        } else {
            $('.input-check').prop('checked', false);
            allRowIds.length = 0;
        }
    
        if (selectedIds.length === 0 || allRowIds.length === 0) {
            $('#makeExcel').hide();
            $('#mark').hide();
        } else {
            $('#makeExcel').show();
            $('#mark').show();
        }
        console.log(allRowIds);
        selectedIds = allRowIds;
        if (selectedIds.length === 0) {
            $('#makeExcel').hide();
            $('#mark').hide();
        } else {
            $('#makeExcel').show();
            $('#mark').show()
        }
    }

    function getSingleRow(checkbox) {
        const rowId = $(checkbox).data('row-num');
    
        if (checkbox.checked) {
            if (selectedIds.length < 30) {
                selectedIds.push(rowId);
            } else {
                checkbox.checked = false;
                alert("You can only select up to 20 checkboxes.");
            }
        } else {
            const index = selectedIds.indexOf(rowId);
            $('#selectAll').prop('checked', false);
            if (index !== -1) {
                selectedIds.splice(index, 1);
            }
        }
    
        if (selectedIds.length === 0) {
            $('#makeExcel').hide();
            $('#mark').hide();
        } else {
            $('#makeExcel').show();
            $('#mark').show();
        }
    
        console.log(selectedIds);
    }

    $(document).ready(function() {
        $('#checkbox-all-columns').on('change', function() {
            var isChecked = $(this).is(':checked');
            $('#checkboxContainer input[type="checkbox"]').prop('checked', isChecked);
        });

        $('#checkboxContainer input[type="checkbox"]').not('#checkbox-all-columns').on('change', function() {
            var allChecked = $('#checkboxContainer input[type="checkbox"]').not('#checkbox-all-columns').length === 
            $('#checkboxContainer input[type="checkbox"]:checked').not('#checkbox-all-columns').length;
            $('#checkbox-all-columns').prop('checked', allChecked);
        });
    });

    $('#downloadExcel').on('click', function() {
        var selectedColumns = [];
        $('#checkboxContainer input[type="checkbox"]:checked').not('#checkbox-all-columns').each(function() {
            selectedColumns.push($(this).val());
        });

        if (selectedColumns.length === 0) {
            $('#colerror').text('Please select at least one column!');
            return;
        }

        // $.ajax({
        //     url: '/export-selected-columns',
        //     type: 'POST',
        //     data: {
        //         properties: selectedIds,
        //         columns: selectedColumns,
        //         _token: $('meta[name="csrf-token"]').attr('content')
        //     },
        //     xhrFields: {
        //         responseType: 'blob'
        //     },
        //     success: function(data) {
        //         var blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        //         var link = document.createElement('a');
        //         link.href = window.URL.createObjectURL(blob);
        //         link.download = 'selected_columns.xlsx';
        //         link.click();
        //     },
        //     error: function(err) {
        //         console.error('Error downloading Excel:', err);
        //     }
        // });
        $.ajax({
            url: '/export-selected-columns',
            type: 'POST',
            data: {
                properties: selectedIds,
                columns: selectedColumns,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            xhrFields: { responseType: 'blob' },
            success: function(blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'boshinghk-retail.xlsx';
                link.click();
                URL.revokeObjectURL(url); // Clean up the URL object
            },
            error: function(error) {
                console.error('Error downloading Excel file:', error);
            }
        });

    });

    $(document).on('click', '#mark', function () {
        let buildingIds = selectedIds;

        $.ajax({
            url: "{{ route('property.share') }}",
            type: "POST",
            data: {
                building_id: buildingIds,
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                updateShareCount();
                // alert(response.message);
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

    $(document).ready(function () {
        let urlParams = new URLSearchParams(window.location.search);
        let type = urlParams.get("type");
        let value = urlParams.get("value");

        if (type && value) {
            if (type === "building") {
                $("#info").val(value);
            } else if (type === "district") {
                $("#district").val(value).change();
            }
            $("#search").click();
        }
    });
</script>
@endsection