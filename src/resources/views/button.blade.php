<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
{{ 
        $attributes->merge(
            [
                'class' => 'rounded px-4 py-2 focus:outline-none ' . $this->getColorClass()
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
