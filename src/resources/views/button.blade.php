<!-- resources/views/button.blade.php -->
<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ 
        $attributes->merge(
            [
                'class' => implode(' ', $classes), 
                'disabled' => $disabled
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
