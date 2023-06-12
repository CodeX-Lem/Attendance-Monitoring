<div class="row gx-1 gy-2 gy-md-0 mt-3 align-items-center justify-content-end">
    <div class="col-md-8 col-xl-6">
        <form action="{{ $searchRoute }}" method="GET">
            <div class="input-group input-group-sm">
                <input type="hidden" class="form-control shadow-none rounded-0" name="entries"
                    value="{{ request('entries', 5) }}" autocomplete="off">
                <input type="text" class="form-control shadow-none rounded-0" placeholder="{{ $searchMessage }}"
                    name="search" autocomplete="off" autofocus>
                <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 rounded-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                    <span>Search</span>
                </button>
            </div>
        </form>
    </div>
    <div class="col-auto">
        <a href="{{ $addRoute }}"
            class="btn btn-sm btn-primary btn-add rounded-0 d-inline-flex align-items-center gap-1">
            <svg xmlns=" http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-folder-plus" viewBox="0 0 16 16">
                <path
                    d="m.5 3 .04.87a1.99 1.99 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2Zm5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19c-.24 0-.47.042-.683.12L1.5 2.98a1 1 0 0 1 1-.98h3.672Z" />
                <path
                    d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5Z" />
            </svg>
            <span>New</span>
        </a>
    </div>
</div>