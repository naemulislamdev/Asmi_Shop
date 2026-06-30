@extends('layouts.front')

@section('content')
    <div class="container py-4">
        <h4 class="searchKeywordText">Search results for: "{{ $keyword }}"</h4>

        <div class="row mt-3 searchResultsContainer">
            @include('frontend.ajax.search_results_page')
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(function () {
    let searchInput = $('.headerSearchInput');
    let typingTimer;
    let doneTypingInterval = 400; // ms debounce

    searchInput.on('input', function () {
        clearTimeout(typingTimer);
        let keyword = $(this).val();

        typingTimer = setTimeout(function () {
            performSearch(keyword);
        }, doneTypingInterval);
    });

    // prevent normal form submit (Enter key) from reloading page
    $('.headerSearchForm').on('submit', function (e) {
        e.preventDefault();
        performSearch(searchInput.val());
    });

    function performSearch(keyword) {
        $.ajax({
            url: "{{ route('front.search') }}",
            type: 'GET',
            data: { search: keyword },
            success: function (response) {
                $('.searchResultsContainer').html(response.html);
                $('.searchKeywordText').text('Search results for: "' + keyword + '"');

                // update URL without reloading
                let newUrl = "{{ route('front.search') }}" + '?search=' + encodeURIComponent(keyword);
                window.history.pushState({}, '', newUrl);
            }
        });
    }
});
</script>
@endpush
