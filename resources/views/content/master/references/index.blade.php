@extends('layouts.master-layout')

@section('content')
    <div>
        @if (session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-alert type="danger" :message="session('error')" />
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
        <span class="text-muted fw-light">Master /</span> Item-Food-Grade-MarketPrice
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create New Item-Food-Grade-MarketPrice</h5>
                    <small class="text-muted float-end">MarketPrice Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.item-food-grades.store') }}" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <!-- Item Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Item Name <span
                                        class="text-danger">*</span></label>
                                <select class="form-select  select2 @error('item_id') is-invalid @enderror" id="item_id"
                                    name="item_id" required>
                                    <option value="">Item select</option>
                                    @foreach ($items as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('item_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Grade Name -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">Grade Name <span
                                        class="text-danger">*</span></label>
                                <select class="form-select select2  @error('food_grade_id') is-invalid @enderror"
                                    id="food_grade_id" name="food_grade_id" required>
                                    <option value="">Grade select</option>
                                    @foreach ($foodGrades as $d)
                                        <option value="{{ $d->id }}"
                                            {{ old('item_id') == $d->id ? 'selected' : '' }}>
                                            {{ $d->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('food_grade_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <!-- market_price -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="market_price">Market Price </label>
                                <input type="text" name="market_price" id="market_price"
                                    class="form-control onlydigit @error('market_price') is-invalid @enderror"
                                    value="{{ old('market_price') }}" placeholder="" required>
                                @error('market_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                                <a href="{{ route('master.item-food-grades.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <!-- TABLE SECTION -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Companies List</h5>
                    <small class="text-muted float-end">All registered companies</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table srkdataTable ">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Item name</th>
                                    <th>Grade name</th>
                                    <th>Market price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Example static row (replace with @foreach later) --}}
                                @foreach ($itemFoodGrades as $d)
                                    <tr>
                                        <td>{{ $d->id }}</td>
                                        <td>{{ $d->item->name }}</td>
                                        <td>{{ $d->foodGrade->name }}</td>
                                        <td>{{ $d->market_price }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                        href="{{ route('master.item-food-grades.edit', $d->id) }}"><i
                                                            class="bx bx-edit-alt me-1"></i> Edit</a>

                                                    <form action="{{ route('master.item-food-grades.destroy', $d->id) }}"
                                                        method="post" onsubmit="return confirmDelete()">

                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger delete-btn"
                                                            data-id="{{ $d->id }}">
                                                            <i class="bx bx-trash me-1"></i> Delete
                                                        </button>

                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>


                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
