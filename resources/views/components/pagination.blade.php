<div class="row m-0 gy-2 gy-md-0 justify-content-between">
    <div class="col-auto">
        <div class="d-flex align-items-center gap-2">
            <span>Show</span>
            <form action="{{ $route }}">
                <select name="entries" class="form-select form-select-sm shadow-none rounded-0"
                    onchange="this.form.submit()">
                    <option value="5" {{ $pageData->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $pageData->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $pageData->perPage() == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ $pageData->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <input type="hidden" class="form-control shadow-none rounded-0" name="search"
                    value="{{ request('search', '') }}" autocomplete="off">
            </form>
            <span>Entries</span>
        </div>
    </div>
    <div class="col-auto">
        <ul class="pagination">
            @php
            $search = request('search', '');
            $entries = request('entries', 5);
            $currentPage = $pageData->currentPage();
            $lastPage = $pageData->lastPage();
            @endphp
            @if ($currentPage == 1)
            <li class="page-item disabled"><span class="page-link rounded-0">Previous</span></li>
            @else
            <li class="page-item"><a class="page-link shadow-none rounded-0"
                    href="{{ $pageData->previousPageUrl() }}&entries={{ $entries }}&search={{ $search }}"
                    rel="prev">Previous</a></li>
            @endif

            <li class="page-item"><span class="page-link rounded-0 text-nowrap active">{{ $currentPage }}
                    of
                    {{ $lastPage }}</span></li>

            @if ($currentPage == $lastPage)
            <li class=" page-item disabled"><span class="page-link rounded-0">Next</span></li>
            @else
            <li class="page-item"><a class="page-link shadow-none rounded-0"
                    href="{{ $pageData->nextPageUrl() }}&entries={{ $entries }}&search={{ $search }}"
                    rel="next">Next</a>
            </li>
            @endif
        </ul>
    </div>
</div>