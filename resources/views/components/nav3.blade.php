<ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
    @foreach ($items as $item)
        <li class="nav-item">
            <a class="nav-link" href="#}"
            {{-- <a class="nav-link" href="{{ route($item['route']) }}" --}}
                style="">
                {{-- style="{{ $item['route'] === $active ? 'color: #ff9922; font-weight: bold;' : '' }}"> --}}
                <i class="{{ $item['icon'] }} mx-4"></i>
                <span>{{ $item['title'] }}</span>
            </a>
        </li>
    @endforeach
</ul>
