@extends('layouts.app')

@section('styles')
{{-- <style>
    .log_section p {
        font-size: 20px;
    }
</style> --}}
@endsection

@section('content')
<section>
    <div class="container bg-white pr-4 pl-4 log_section pb-5 mt-2">

        <div class="row">
            <div class="col-12">
                <h3>Terms &amp; Conditions</h3>
                <p class="text-justify">
                    1. All materials and contents contained in this website, including but not limited to text, photographs, video, logos, and other materials, are the property of the Company and are protected by copyright or other intellectual property rights. None of such material and content shall be copied, reproduced, or modified.
                    <br><br>
                    2. The Company has the right to remove any information that you have uploaded or saved to this website without prior notice.
                    <br><br>
                    3. Information provided on this website is for reference only. The Company makes no warranty, including but not limited to any warranty on or in relation to the following matters and shall not be responsible or liable for any losses incurred under all circumstances:
                    <br>
                    (i) the accuracy of the contents contained therein;
                    <br>
                    (ii) the stability or availability of this website;
                    <br>
                    (iii) the services or products available from this website.
                    <br><br>
                    4. The Company shall not be liable for any losses which you have suffered or may suffer as a result of your use or misuse of this website or your reliance on any information or content from this website.
                    <br><br>
                    5. You shall indemnify the Company for any loss, including but not limited to legal costs and expenses incurred by your misuse of this website.
                    <br><br>
                    6. The Company has the right to amend the terms and conditions herein, and you shall be bound by such amendments.
                    <br><br>
                    7. These terms and conditions shall be governed by and construed in accordance with the laws of the Hong Kong Special Administrative Region.
                </p>
            </div>
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

@endsection