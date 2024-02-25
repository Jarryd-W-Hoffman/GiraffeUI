<!-- resources/views/button.blade.php -->
<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ 
        $attributes->merge(
            [
                'class' => $classes
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
