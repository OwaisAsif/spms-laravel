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
    </style> --}}
@endsection

@section('content')
<form action="{{ route('update.size.price', $property->code) }}" method="post" enctype="multipart/form-data">
    @csrf
    <!-- <form action="" method="post"> -->
    <div class="mt-2">
        <div class="container">
            <div id="step-6">
                <h3>Size/Price</h3>
                <div class="row">
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold">Gross Sf: </label>
                        <input type="number" name="gross_sf" step="0.01" class="form-control" id="gross_sf" value="{{ $property->gross_sf }}">
                    </div>
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold">Net Sf: </label>
                        <input type="number" name="net_sf" step="0.01" class="form-control" id="net_sf" value="{{ $property->net_sf }}">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12 d-flex">
                        <label for="" class="font-weight-bold mr-1">Selling Price (M):</label>
                        <input type="number" name="selling" step="0.01" class="form-control" id="selling" value="{{ $property->selling_price }}">
                    </div>
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold mt-2 mr-2">G@</label>
                        <input type="number" name="selling_g" step="0.01" class="form-control" id="selling_g" readonly="" value="{{ $property->selling_g }}">
                    </div>
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold mt-2 mr-2">N@</label>
                        <input type="number" name="selling_n" step="0.01" class="form-control" id="selling_n" readonly="" value="{{ $property->selling_n }}">
                    </div>
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="row mt-3">
                    <div class="col-12 d-flex">
                        <label for="" class="font-weight-bold mr-1">Rental Price:</label>
                        <input type="number" name="rental" step="0.01" class="form-control" id="rental" value="{{ $property->rental_price }}">
                    </div>
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold mt-2 mr-2">G@</label>
                        <input type="number" name="rental_g" step="0.01" class="form-control" id="rental_g" value="{{ $property->rental_g }}">
                    </div>
                    <div class="col-6 d-flex">
                        <label for="" class="font-weight-bold mt-2 mr-2">N@</label>
                        <input type="number" name="rental_n" step="0.01" class="form-control" id="rental_n" value="{{ $property->rental_n }}">
                    </div>
                </div>
                <div class="container">
                    <hr>
                </div>
                <div class="row mt-2">
                    <div class="col-12 d-flex ">
                        <label for="" class="font-weight-bold mr-2 mt-2">Mgmf: </label>
                        <input type="text" class="form-control" name="mgmf" id="mgmf" value="{{ $property->mgmf }}">
            
                    </div>
                    <div class="col-12 d-flex mt-2">
                        <label for="" class="font-weight-bold mr-2 mt-2">Rate: </label>
                        <input type="text" class="form-control" name="rate" id="rate" value="{{ $property->rate }}">
            
                    </div>
                    <div class="col-12 d-flex mt-2">
                        <label for="" class="font-weight-bold mr-2 mt-2">Land: </label>
                        <input type="text" class="form-control" name="land" id="land" value="{{ $property->land }}">
            
                    </div>
                    <div class="col-12 d-flex mt-2">
                        <label for="" class="font-weight-bold mr-2 mt-2">Oths: </label>
                        <input type="text" class="form-control" name="oths" id="oths" value="{{ $property->oths }}">
            
                    </div>
                </div>
            
                <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg last_sub mt-5">UPDATE</button>
            </div>
        </div>
    </div>
    <!-- </form> -->
</form>

@endsection

@section('scripts')
<script>
    // size/price calculate
    $(document).ready(function() {
        $('#gross_sf').keyup(function(e) {
            let arr = layer();
            let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
            let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;

            var calArray = calculationFunction(arr[0], arr[1], sell);
            $('#selling_g').val(calArray[0]);
            $('#selling_n').val(calArray[1]);
            var calArray = calculationFunction(arr[0], arr[1], rental);
            $('#rental_g').val(calArray[0]);
            $('#rental_n').val(calArray[1]);
        });
        
        $('#rental_g').keyup(function(e) {
            let arr = layer();
            $('#rental').val(arr[0] * $(this).val())
        });
        
        $('#rental_n').keyup(function(e) {
            let arr = layer();
            $('#rental').val(arr[1] * $(this).val())
        });
        
        $('#net_sf').keyup(function(e) {
            let arr = layer();
            let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
            let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;

            var calArray = calculationFunction(arr[0], arr[1], sell);
            $('#selling_g').val(calArray[0]);
            $('#selling_n').val(calArray[1]);
            var calArray = calculationFunction(arr[0], arr[1], rental);
            $('#rental_g').val(calArray[0]);
            $('#rental_n').val(calArray[1]);
        });
        $('#selling').keyup(function(e) {
            let arr = layer();
            let sell = $('#selling').val() ? parseFloat($('#selling').val() * 1000000) : 0;
            let calArray = calculationFunction(arr[0], arr[1], sell);
            $('#selling_g').val(calArray[0]);
            $('#selling_n').val(calArray[1]);
        });
        $('#rental').keyup(function(e) {
            let arr = layer();
            let rental = $('#rental').val() ? parseFloat($('#rental').val()) : 0;
            let calArray = calculationFunction(arr[0], arr[1], rental);
            $('#rental_g').val(calArray[0]);
            $('#rental_n').val(calArray[1]);
        });

        function layer() {
            let a = $('#gross_sf').val() ? parseFloat($('#gross_sf').val()) : 0;
            let b = $('#net_sf').val() ? parseFloat($('#net_sf').val()) : 0;
            return [a, b];
        }


        function calculationFunction(a, b, main) {
            console.log(a)
            console.log(b)
            console.log(main)
            let G = parseFloat(main / a).toFixed(2);
            let N = parseFloat(main / b).toFixed(2);
            return [G, N];
        }

    });
</script>
@endsection