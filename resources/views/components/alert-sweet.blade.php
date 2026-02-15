{{-- @props(['type' => 'success', 'message' => '']) --}}
@props([
    'timer' => 5000,
])

@php
    $type = null;
    $message = null;

    if ($errors->any()) {
        $type = 'error';
        $message = $errors->first();
    } elseif (session('success')) {
        $type = 'success';
        $message = session('success');
    } elseif (session('error')) {
        $type = 'error';
        $message = session('error');
    } elseif (session('warning')) {
        $type = 'warning';
        $message = session('warning');
    }
@endphp

@if ($message)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Swal.fire({
            //     title: "{{ ucfirst($type) }}",
            //     text: "{{ $message }}",
            //     icon: "{{ $type }}",
            //     confirmButtonText: 'OK',
            //     timer: 3000,
            //     showConfirmButton: false
            // });
            Swal.fire({
                title: @json(ucfirst($type)),
                text: @json($message),
                icon: @json($type),
                timer: {{ $timer }},
                confirmButtonText: 'OK',
                showConfirmButton: false,
                timerProgressBar: true,
                allowOutsideClick: true,
                draggable: true
            });
        });
    </script>
@endif
