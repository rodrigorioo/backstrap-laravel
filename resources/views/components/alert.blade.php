@push('js')
    <script>
        @if (session('alert'))
            Swal.fire({
                title: "{{ session('alert')['title'] }}",
                text: "{{ session('alert')['text'] }}",
                icon: "{{ session('alert')['icon'] }}",
                confirmButtonText: "{{ session('alert')['confirm_button_text'] }}"
            });
        @endif
    </script>
@endpush