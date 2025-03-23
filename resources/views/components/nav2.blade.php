
@foreach ($items as $item)
    <li class="nav-item">
        <a class="nav-link"
        style="{{ $item['route'] === $active ? 'color: #ff9922; font-weight: bold;' : '' }}"
        {{-- href="{{ route($item['route']) }}" > --}}
        href="#" >
        <i class="{{ $item['icon'] }} mx-4"></i>
            <span>{{ $item['title'] }}</span>
        </a>
    </li>
@endforeach
