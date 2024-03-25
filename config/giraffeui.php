<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Use Tailwind Config
    |--------------------------------------------------------------------------
    |
    | If you are using Tailwind CSS, you can use the colors from your
    | Tailwind config file. If you are not using Tailwind CSS, you can
    | define your own colors in the 'colors' array below.
    |
    */

    'use_tailwind_config' => false,

    /*
    |--------------------------------------------------------------------------
    | Color Settings
    |--------------------------------------------------------------------------
    |
    | Define colors for GiraffeUI components. You can customize the appearance
    | of various UI elements by configuring the color settings below. The
    | 'colors' array consists of predefined color schemes for primary, secondary,
    | success, danger, warning, info, light, and dark components.
    |
    | Each color scheme is defined by the following structure:
    |
    | 'color_name' => [
    |     'base' => [
    |         'color' => 'base_color',   // Base color for the component
    |         'shade' => 'shade_level',  // Shade level for the component
    |         'opacity' => null,         // Opacity for the component (null means no opacity)
    |     ],
    |     'text_color' => 'text_color',  // Text color for the component
    | ],
    |
    | You can add custom color properties by following the same template.
    | Simply add a new key with your desired 'color_name', and provide
    | the 'base' and 'text_color' values accordingly.
    |
    */

    'colors' => [

        'primary' => [
            'base' => [
                'color' => 'blue',
                'shade' => '500',
                'opacity' => null,
            ],
            'text_color' => 'white',
        ],

        'secondary' => [
            'base' => [
                'color' => 'gray',
                'shade' => '500',
                'opacity' => null,
            ],
            'text_color' => 'black',
        ],

        'success' => [
            'base' => [
                'color' => 'green',
                'shade' => '600',
                'opacity' => null,
            ],
            'text_color' => 'white',
        ],

        'danger' => [
            'base' => [
                'color' => 'red',
                'shade' => '500',
                'opacity' => null,
            ],
            'text_color' => 'white',
        ],

        'warning' => [
            'base' => [
                'color' => 'yellow',
                'shade' => '400',
                'opacity' => null,
            ],
            'text_color' => 'black',
        ],
        
        'info' => [
            'base' => [
                'color' => 'teal',
                'shade' => '400',
                'opacity' => null,
            ],
            'text_color' => 'white',
        ],

        'light' => [
            'base' => [
                'color' => 'gray',
                'shade' => '100',
                'opacity' => null,
            ],
            'text_color' => 'black',
        ],

        'dark' => [
            'base' => [
                'color' => 'gray',
                'shade' => '900',
                'opacity' => null,
            ],
            'text_color' => 'white',
        ],    
    ],

    /*
    |--------------------------------------------------------------------------
    | Size Settings
    |--------------------------------------------------------------------------
    |
    | Define size settings for GiraffeUI components. Customize the spacing
    | and text size of various UI elements by configuring the size settings
    | below. The 'sizes' array consists of predefined size schemes for small,
    | default, and large components.
    |
    | Each size scheme is defined by the following structure:
    |
    | 'size_name' => [
    |     'horizontal_spacing' => 'spacing_value', // Horizontal spacing for the component (relates to Tailwind utility classes, e.g., 2 = px-2)
    |     'vertical_spacing' => 'spacing_value',   // Vertical spacing for the component (relates to Tailwind utility classes, e.g., 1 = py-1)
    |     'text_size' => 'text_size_value',        // Text size for the component (relates to Tailwind utility classes, e.g., xs = text-xs)
    | ],
    |
    | You can add custom size properties by following the same template.
    | Simply add a new key with your desired 'size_name', and provide
    | the 'horizontal_spacing', 'vertical_spacing', and 'text_size' values accordingly.
    |
    */

    'sizes' => [

        'small' => [
            'horizontal_spacing' => '2',
            'vertical_spacing' => '1',
            'text_size' => 'xs',
        ],

        'default' => [
            'horizontal_spacing' => '4',
            'vertical_spacing' => '2',
            'text_size' => 'sm',
        ],
        
        'large' => [
            'horizontal_spacing' => '6',
            'vertical_spacing' => '3',
            'text_size' => 'base',
        ],
    ],
];
