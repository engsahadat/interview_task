@extends('layouts.app')
@section('title', 'Upload File')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">{{ __('File Upload Form') }}</h2>
                <div class="card my-5">
                    <form id="fileupload-form" class="card-body cardbody-color p-lg-5">
                        <div class="mb-3">
                            <label for="file" class="form-label">{{ __('Upload File') }}</label>
                            <input type="file" class="form-control" name="file">
                            <p class="text-danger d-none error-message" id="file-error"></p>
                        </div>
                        <div class="text-center">
                            <button id="submit-button" type="button" class="btn btn-success px-5 mb-5 w-100">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $('#submit-button').click(function () {
            const form = $('#fileupload-form');
            let formData = new FormData(form[0]);
            const spinner = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="visually-hidden">Loading...</span>`;
            $('#submit-button').html(spinner);
            $('.error-message').addClass('d-none').html('');

            axios.post("{{ route('file.store') }}", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                method: 'post',
                params: {
                    '_method': 'POST'
                }
            })
            .then(response => {
                if (response.status === 200) {
                    Toastify({
                        text: response.data.message,
                        backgroundColor: "green",
                        close: true,
                    }).showToast();
                    setTimeout(function () {
                        window.location.href = response.data.redirect;
                    }, 1000);
                }
            })
            .catch(error => {
                console.log(error.response);
                if (error.response && error.response.status === 422) {
                    let errors = error.response.data.errors;
                    for (let field in errors) {
                        $(`#${field}-error`).removeClass('d-none').html(errors[field][0]);
                    }
                } else if (error.response && error.response.status === 401) {
                    const invalidError = error.response.data.error;
                    $('#invalid-error').removeClass('d-none').html(invalidError);
                } else {
                    console.error("An unexpected error occurred.");
                }
            })
            .finally(() => {
                $('#submit-button').html('Submit');
            });
        });
    </script>
@endsection