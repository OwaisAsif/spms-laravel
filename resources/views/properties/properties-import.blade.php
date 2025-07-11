@extends('layouts.app')

@section('content')
<section>
    <div class="container">
        <form method="post" action="{{ route('import.properties') }}" enctype="multipart/form-data">
            @csrf
            <h3>Import Bulk Properties</h3>
            <div class="row">
               
                <div class="col-12">
                    <label for="">Upload Excel File</label>
                    <input type="file" name="file" class="form-control">
                </div>
            </div>
          
            <button type="submit" name="submit" class="btn btn-block font-weight-bold log_btn btn-lg mt-4">Upload</button>
        </form>
    </div>

</section>
@endsection