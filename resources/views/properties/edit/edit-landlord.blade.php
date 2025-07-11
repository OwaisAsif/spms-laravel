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
    .sw-theme-arrows>.nav .nav-link.active {
        --sw-anchor-active-primary-color: #5bc0de;
    }
</style> --}}
@endsection

@section('content')

<form action="{{ route('update.landlord', $property->code) }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="mt-2">
        <div class="container">
            <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                <h3>Landlord Details</h3>
                <div class="row">
                    <div class="col-6">
                        <label for="">Contact 1</label>
                        <input type="text" class="form-control mb-3" placeholder="Contact 1" name="contact1" value="{{ $property->contact1 }}">
                    </div>
                    <div class="col-6">
                        <label for="">
                            Number 1
                            <span class="eye-icon"
                                id="toggleVisibility1"
                                style="cursor: pointer;"
                                data-full-number="{{ $property->number1 }}">
                                👁️
                            </span>
                        </label>
                        <input type="password" class="form-control mb-3" placeholder="Number 1" id="numberField1" name="number1" value="{{ $property->number1 }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Contact 2</label>
                        <input type="text" class="form-control mb-3" placeholder="Contact 2" name="contact2" value="{{ $property->contact2 }}">
                    </div>
                    <div class="col-6">
                        <label for="">
                            Number 2
                            <span class="eye-icon"
                                id="toggleVisibility2"
                                style="cursor: pointer;"
                                data-full-number="{{ $property->number2 }}">
                                👁️
                            </span>
                        </label>
                        <input type="password" class="form-control mb-3" placeholder="Number 2" name="number2" id="numberField2" value="{{ $property->number2 }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Contact 3</label>
                        <input type="text" class="form-control mb-3" placeholder="Contact 3" name="contact3" value="{{ $property->contact3 }}">
                    </div>
                    <div class="col-6">
                        <label for="">
                            Number 3
                            <span class="eye-icon"
                                id="toggleVisibility3"
                                style="cursor: pointer;"
                                data-full-number="{{ $property->number3 }}">
                                👁️
                            </span>
                        </label>
                        <input type="password" class="form-control mb-3" placeholder="Number 3" id="numberField3" name="number3" value="{{ $property->number3 }}">
                    </div>
                </div>
                <label for="">Landlord Name</label>
                <input type="text" class="form-control mb-3" placeholder="Landlord Name" name="landlord_name" value="{{ $property->landlord_name }}">

                <label for="">Management Company</label>
                <input type="text" class="form-control mb-3" placeholder="Management Company" name="management_company" value="{{ $property->management_company }}">

                <label for="">Bank</label>
                <input type="text" class="form-control mb-3" placeholder="Bank" name="bank" value="{{ $property->bank }}">

                <label for="">Bank Account</label>
                <input type="text" class="form-control mb-3" placeholder="Bank account" name="bank_account" value="{{ $property->bank_acc }}">

                <label for="">Remark</label>
                <textarea name="remark" class="form-control mb-3" placeholder="Remark" id="" cols="30" rows="5">{{ $property->remarks }}</textarea>
                <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">UPDATE</button>
            </div>
        </div>
    </div>
    <!-- </form> -->
</form>

@endsection

@section("scripts")
<script>
  $(document).ready(function() {
        $('.eye-icon').on('click', function() {
            var $icon = $(this);
            var $input = $icon.closest('.col-6').find('input');

            if ($input.attr('type') === 'password') {
                $input.attr('type', 'text');
                $icon.text('🙈');
            } else {
                $input.attr('type', 'password');
                $icon.text('👁️');
            }
        });
    });

</script>
@endsection