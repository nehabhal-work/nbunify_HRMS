@extends('layouts.master-layout')
@section('title', 'bday')

@section('content')
    <style>
        /* TODAY – blinking + glow */
        .birthday-today {
            font-weight: 700;
            color: #198754;
            animation: blinkGlow 1.2s infinite;
        }

        /* TOMORROW – pulse (no blink, smoother) */
        .birthday-tomorrow {
            font-weight: 600;
            color: #0d6efd;
            animation: pulse 1.5s infinite;
        }

        /* Animations */
        @keyframes blinkGlow {
            0% {
                opacity: 1;
                text-shadow: 0 0 5px #198754;
            }

            50% {
                opacity: 0.4;
                text-shadow: 0 0 15px #198754;
            }

            100% {
                opacity: 1;
                text-shadow: 0 0 5px #198754;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.85;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
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
        <span class="text-muted fw-light">Master /</span> <a href="#">B'day list'</a>
    </h4>



    <div class="row">
        <div class="container my-5">

            <!-- Filter Section -->
            <form method="GET" action="{{ route('birthday-client') }}">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row g-3 align-items-end">

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">From Date</label>
                                <input type="date" name="from_date" class="form-control" value="">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label fw-semibold">To Date</label>
                                <input type="date" name="to_date" class="form-control" value="">
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Go
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold">🎂 Client Birthday List</h3>

                <button class="btn btn-success">
                    <i class="bi bi-download"></i> Export List
                </button>
            </div>

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle srkdataTable">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Client Name</th>
                                    <th>DOB</th>
                                    <th>Age</th>
                                    <th>Mobile</th>
                                    <th>Category</th>
                                    <th>Birthday Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $key => $d)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><strong>{{ $d['name'] }}</strong></td>

                                        <td>{{ \Carbon\Carbon::parse($d['dob'])->format('d M Y') }}</td>

                                        <td>{{ \Carbon\Carbon::parse($d['dob'])->age }}</td>

                                        <td>{{ $d['mobile'] }}</td>

                                        <td>
                                            @if ($d['birthday_status'] === 'Today')
                                                🎂 <span class="badge bg-success birthday-today">TODAY </span>🎉
                                            @elseif($d['birthday_status'] === 'Yesterday')
                                                <span class="badge bg-danger text-dark">YESTERDAY</span>
                                            @elseif($d['birthday_status'] === 'Tomorrow')
                                                <span class="badge bg-warning birthday-tomorrow">
                                                    🎁 TOMORROW
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">{{ $d['birthday_status'] }}</span>
                                            @endif
                                        </td>


                                        <td>
                                            @if ($d['birthday_status'] === 'Today' || $d['birthday_status'] === 'Yesterday')
                                                <button class="btn btn-sm btn-outline-primary send-wish-btn"
                                                    data-client-id="{{ $d['id'] }}"
                                                    data-client-name="{{ $d['name'] }}">
                                                    <i class="bi bi-send"></i> Send Wish
                                                </button>
                                            @else
                                                -
                                            @endif
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.send-wish-btn').on('click', function() {
                const button = $(this);
                const clientId = button.data('client-id');
                const clientName = button.data('client-name');

                // Disable button and show loading
                button.prop('disabled', true).html(
                    '<i class="spinner-border spinner-border-sm"></i> Sending...');

                $.ajax({
                    url: '{{ route('send-birthday-email') }}',
                    method: 'POST',
                    data: {
                        client_id: clientId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            button.removeClass('btn-outline-primary').addClass('btn-success')
                                .html('<i class="bi bi-check"></i> Sent');

                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: `Birthday email sent to ${clientName}`,
                                timer: 3000,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error(response.error || 'Unknown error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to send email';

                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }

                        // Re-enable button
                        button.prop('disabled', false).html(
                            '<i class="bi bi-send"></i> Send Wish');

                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
@endpush
