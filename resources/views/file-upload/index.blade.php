@extends('layouts.app')
@section('title', 'File list')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h4>File List</h4>
            <a class="btn btn-success" href="{{ route('file.create') }}">Upload File</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <a class="btn btn-primary" href="{{ route('file.download', ['filename' => $filename]) }}">Download File</a>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>{{ __('Sl') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('File Name') }}</th>
                        <th>{{ __('File Path') }}</th>
                        <th>{{ __('Mime Types') }}</th>
                        <th>{{ __('Size') }}</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection