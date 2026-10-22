@props([
    'class' => 'w-4 h-3 rounded-[2px] shadow-xs'
])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 225 150" class="inline-block flex-shrink-0 {{ $class }}" aria-label="Flag of India">
    <!-- Saffron Stripe -->
    <rect width="225" height="50" fill="#FF9933"/>
    <!-- White Stripe -->
    <rect y="50" width="225" height="50" fill="#FFFFFF"/>
    <!-- Green Stripe -->
    <rect y="100" width="225" height="50" fill="#138808"/>
    <!-- Ashoka Chakra -->
    <g transform="translate(112.5, 75)">
        <circle r="20" fill="none" stroke="#000080" stroke-width="2.5"/>
        <circle r="4" fill="#000080"/>
        <!-- 24 Spokes -->
        @for($i = 0; $i < 24; $i++)
            <line x1="0" y1="0" x2="0" y2="-19" stroke="#000080" stroke-width="1.2" transform="rotate({{ $i * 15 }})"/>
        @endfor
    </g>
</svg>
