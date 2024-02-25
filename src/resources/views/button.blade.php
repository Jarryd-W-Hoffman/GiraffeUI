<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ 
        $attributes->merge(
            [
                'class' => ''
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
