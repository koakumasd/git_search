<nav >
    <ul class="pagination">
        @if (!empty($prev_number))
            <li class='page-item'><a class='page-link' href='{{ $url.$prev_number }}'>Previous</a></li>
        @endif
        @foreach ($pages->all() as $page)
            <li class='page-item'><a class='page-link' href='{{ $url.$page }}'>{{ $page }}</a></li>
        @endforeach
        @if (!empty($next_number))
            <li class='page-item'><a class='page-link' href='{{ $url.$next_number }}'>Next</a></li>
        @endif
    </ul>
</nav>