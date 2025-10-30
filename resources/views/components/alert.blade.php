@props(['type' => 'success', 'message' => ''])

@if ($message)
    <div class="alert-container">
        <div class="alert alert-{{ $type }} alert-dismissible fade show shadow-lg custom-alert" role="alert">
            <strong>{{ ucfirst($type) }}:</strong> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <style>
        .alert-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1055;
            /* Slightly lower than modal backdrop but higher than page */
            min-width: 350px;
            max-width: 600px;
            text-align: center;
        }

        /* ✅ Custom Colors (Bootstrap overrides) */
        .custom-alert.alert-success {
            background-color: #42948E !important;
            color: #fff !important;
            border: none !important;
        }

        .custom-alert.alert-danger {
            background-color: #dc3545 !important;
            color: #fff !important;
            border: none !important;
        }

        .custom-alert.alert-warning {
            background-color: #ffc107 !important;
            color: #000 !important;
            border: none !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto-dismiss after 4 seconds
            setTimeout(() => {
                const alertBox = document.querySelector('.alert-container .alert');
                if (alertBox) {
                    bootstrap.Alert.getOrCreateInstance(alertBox).close();
                }
            }, 4000);
        });
    </script>
@endif
