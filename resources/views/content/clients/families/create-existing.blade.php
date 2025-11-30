@extends('layouts.master-layout')

@section('content')
    <div>
        @if (session('success'))
            <x-alert-sweet type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert-sweet type="danger" :message="session('error')" />
        @endif


    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Family /</span> <a href="{{ route('master.companies.index') }}">Add Family Member
            from existing list
            <span class="text-uppercase">{{ $client->name }}</span></a>
    </h4>



    <form action="{{ route('client-families.store.existing') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('post')
        <input type="hidden" name="client_id" value="{{ $client->id }}">





        <div id="existingSection">
            <div class="card p-5">
                <div class="row">

                    <!-- Client Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label for="existing_client_id" class="form-label">Select Existing Client</label>
                        <select name="existing_client_id" id="existing_client_id"
                            class="form-select select2 @error('existing_client_id') is-invalid @enderror">
                            <option value="">Select Client</option>
                            @foreach ($clients as $c)
                                <option value="{{ $c->id }}"
                                    {{ old('existing_client_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('existing_client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Relation With Client -->
                    <div class="col-md-3 mb-3">
                        <label for="existing_relation_id" class="form-label">Relation With Client</label>
                        <select name="existing_relation_id" id="existing_relation_id" class="form-select select2">
                            <option value="">Select Relation</option>
                            @foreach ($relations as $d)
                                <option value="{{ $d->id }}"
                                    {{ old('existing_relation_id') == $d->id ? 'selected' : '' }}>
                                    {{ $d->main_relation }}</option>
                            @endforeach
                        </select>

                        @error('existing_relation_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>



        <div class="text-end mt-3">
            <button type="submit" class="btn btn-primary px-4">Save</button>
            <a href="{{ route('clients.index') }}" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </form>


@endsection
