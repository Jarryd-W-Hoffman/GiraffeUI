<{{ $link ? 'a' : 'button' }} 
    @if ($link) 
        href="{{ $link }}" 
        @if ($external)
            {!! $external ? 'target="_blank" rel="noopener noreferrer"' : '' !!}
        @else
            wire:navigate
        @endif
    @else
        type="{{ $type }}" 
        {{ $disabled ? 'disabled' : '' }} 
    @endif
    onclick="{!! $event !!}"
    {{
        $attributes->merge(
            [
                'class' => 'flex justify-center items-center gap-4 focus:outline-none ' 
                    . $colorStyles
                    . $sizeStyles
                    . (!$link && $disabled ? 'opacity-50 cursor-not-allowed ' : '')
                    . ($fullWidth ? 'w-full ' : '')
            ]
        ) 
    }}
>
    {{ $slot }}
</{{ $link ? 'a' : 'button' }}>
