<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ 
        $attributes->merge(
            [
                'class' => '{{ $fullWidth ? "w-full" : "" }}
                            {{ $size === "sm" ? "px-2.5 py-1.5 text-xs" : ""}}
                            {{ $size === "md" ? "px-3 py-2 text-sm" : "" }}
                            {{ $size === "lg" ? "px-4 py-2 text-base" : "" }}
                            {{ $variant === "primary" ? "bg-indigo-600 border-transparent text-white hover:bg-indigo-700" : "" }}
                            {{ $variant === "secondary" ? "bg-white border-gray-300 text-gray-700 hover:bg-gray-50" : "" }}
                            {{ $variant === "danger" ? "bg-red-600 border-transparent text-white hover:bg-red-700" : "" }}
                            {{ $variant === "warning" ? "bg-yellow-500 border-transparent text-white hover:bg-yellow-600" : "" }}
                            {{ $variant === "success" ? "bg-green-600 border-transparent text-white hover:bg-green-700" : "" }}
                            {{ $variant === "info" ? "bg-blue-600 border-transparent text-white hover:bg-blue-700" : "" }}
                            {{ $variant === "light" ? "bg-gray-100 border-gray-300 text-gray-700 hover:bg-gray-200" : "" }}
                            {{ $variant === "dark" ? "bg-gray-800 border-transparent text-white hover:bg-gray-900" : "" }}
                            {{ $variant === "link" ? "bg-transparent border-transparent text-indigo-600 hover:text-indigo-800" : "" }}'
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
