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
    | Define size settings for GiraffeUI components.
    |
    */

    'sizes' => [
        'small' => [
            'horizontal_spacing' => '2', // Horizontal spacing for small components (0.5rem || 8px)
            'vertical_spacing' => '1', // 0.25rem || 4px
            'text_size' => 'xs', // font-size: 0.75rem || 12px || line-height: 1rem || 16px 
        ],
        'default' => [
            'horizontal_spacing' => '4', // 1rem || 16px
            'vertical_spacing' => '2', // 0.5rem || 8px
            'text_size' => 'sm', // font-size: 0.875rem || 14px || line-height: 1.25rem || 20px
        ],
        'large' => [
            'horizontal_spacing' => '6', // 1.5rem || 24px
            'vertical_spacing' => '3', // 0.75rem || 12px
            'text_size' => 'base', // font-size: 1rem || 16px || line-height: 1.5rem || 24px
        ],
    ],
];
