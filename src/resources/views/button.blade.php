<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ 
        $attributes->merge(
            [
                'class' => 'rounded focus:outline-none {{ $colorStyles }} {{ $sizeStyles }}'
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
