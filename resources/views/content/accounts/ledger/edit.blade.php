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
        <span class="text-muted fw-light">Master /</span> Item-Food-Grade-MarketPrice Edit
    </h4>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Item-Food-Grade-MarketPrice</h5>
                    <small class="text-muted float-end">MarketPrice Information</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('master.item-food-grades.update', $itemFoodGrade->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="row g-3">
                                <!-- Item Name -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Item Name <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" name="item_id" required>
                                        <option value="">Select Item</option>
                                        @foreach ($items as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $itemFoodGrade->item_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Grade Name -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Grade Name <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2" name="food_grade_id" required>
                                        <option value="">Select Grade</option>
                                        @foreach ($foodGrades as $grade)
                                            <option value="{{ $grade->id }}"
                                                {{ $itemFoodGrade->food_grade_id == $grade->id ? 'selected' : '' }}>
                                                {{ $grade->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Market Price -->
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Market Price</label>
                                    <input type="text" name="market_price" class="form-control onlydigit"
                                        value="{{ $itemFoodGrade->market_price }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update</button>
                                <a href="{{ route('master.item-food-grades.index') }}" class="btn btn-secondary px-4">Back</a>
                            </div>
                    </form>

                </div>
            </div>
        </div>

     
    </div>
@endsection
