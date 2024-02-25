<{{ $link ? 'a' : 'button' }} 
    @if($link) 
        href="{{ $link }}" 
    @endif
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {{ 
        $attributes->merge(
            [
                'class' => '{{ $fullWidth && "w-full" }}
                            {{ $size === "small" && "px-2 py-1 text-xs" }}
                            {{ $size === "medium" && "px-4 py-2 text-sm" }}
                            {{ $size === "large" && "px-6 py-3 text-base" }}
                            {{ $color === "primary" && "bg-indigo-600 border-transparent text-white hover:bg-indigo-700" }}
                            {{ $color === "secondary" && "bg-white border-gray-300 text-gray-700 hover:bg-gray-50" }}
                            {{ $color === "danger" && "bg-red-600 border-transparent text-white hover:bg-red-700" }}
                            {{ $color === "warning" && "bg-yellow-500 border-transparent text-white hover:bg-yellow-600" }}
                            {{ $color === "success" && "bg-green-600 border-transparent text-white hover:bg-green-700" }}
                            {{ $color === "info" && "bg-blue-600 border-transparent text-white hover:bg-blue-700" }}
                            {{ $variant === "contained" && "bg-gray-100 border-gray-300 text-gray-700 hover:bg-gray-200" }}
                            {{ $variant === "outline" && "bg-gray-800 border-transparent text-white hover:bg-gray-900" }}
                            {{ $variant === "link" && "bg-transparent border-transparent text-indigo-600 hover:text-indigo-800" }}
                            {{ $disabled && "opacity-50 cursor-not-allowed" }}'
            ]
        ) 
    }}
>
    {{ $text }}
</{{ $link ? 'a' : 'button' }}>
