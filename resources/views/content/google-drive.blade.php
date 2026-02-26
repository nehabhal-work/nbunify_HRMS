@extends('layouts.master-layout')
@section('title', 'gd')
@section('title', 'gdrive')

@section('content')
    <h1>google drive</h1>

    <div class="row">
        <div class="col-6">

            <form action="{{ route('google-drive-upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="" class="form-label">Choose file</label>
                    <input type="file" class="form-control" name="myfile" id="" placeholder=""
                        aria-describedby="fileHelpId" />
                    <div id="fileHelpId" class="form-text">Help text</div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="" id="" class="btn btn-primary">
                        Button
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
