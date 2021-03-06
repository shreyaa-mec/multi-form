@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <form id="stepTwo" enctype="multipart/form-data" method="POST">
                @csrf

                <div class="card">
                    <div class="card-header">Step 2:Company Details</div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="title">Company Name:</label>
                            <input type="text" value="{{ $user->company_name ?? '' }}"class="form-control" id="company_name" name="company_name">
                        </div>
                        <div class="form-group">
                            <label for="description">Address:</label>
                            <textarea type="text"class="form-control" id="address" name="address">{{ $user->address ?? '' }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="description">Zip-Code:</label>
                            <input class="form-control" value="{{ $user->company_zipcode ?? '' }}" id="company_zipcode" name="company_zipcode" type="text" pattern="[0-9]*">
                        </div>

                        <div class="form-group">
                            <label for="description">Website:</label>
                            <input class="form-control" id="website" value="{{ $user->website ?? '' }}" name="website" type="url">
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button type="button" id="back" class="btn btn-info">Back</button>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
    $(document).ready(function() {

        $('#back').click(function() {
            window.location.href  = "{{ route('stepOneForm') }}";
        })

        $('#stepTwo').validate({
            rules: {
                company_name: {
                    required: true,
                },
                address: {
                    required: true,
                },
                company_zipcode: {
                    required: true,
                },
                website: {
                    required: true,
                }
            },
            messages: {
                company_name: {
                    required: "Company Name is required",
                },
                address: {
                    required: "Address is required",
                },
                company_zipcode: {
                    required: "ZipCode is required",
                },
                website: {
                    required: "Website is required",
                }
            },
            submitHandler: function(form) {

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: "{{route('step-two')}}",
                    method: "POST",
                    data: new FormData(form),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status == true) {

                            window.location.href = '{{route("stepThreeForm")}}';
                        }
                    },
                    error: function(response) {
                        $('.text-strong').text('');
                        $.each(response.responseJSON.errors, function(field_name, error) {
                            $('[name=' + field_name + ']').after('<span class="text-strong" style="color:red">' + error + '</span>')
                        })
                    }
                });
            }
        })
    })
</script>