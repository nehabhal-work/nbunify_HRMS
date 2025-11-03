@props(['type' => 'success', 'message' => ''])

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
                title: "{{ $message }}!",
                icon: "success",
                draggable: true
            });
        });
    </script>
@endif
