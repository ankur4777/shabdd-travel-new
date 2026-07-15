@push('scripts')
    <script>
        (() => {
            const elements = document.querySelectorAll('[data-mb-reveal]');
            elements.forEach(element => element.classList.add('is-visible'));
        })();
    </script>
@endpush
