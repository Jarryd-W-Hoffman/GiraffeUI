<?php

namespace JayAitch\GiraffeUI\Components;

use Illuminate\View\Component;

class Button extends Component
{
    /**
     * The color of the button.
     *
     * @var string
     **/
    public $color;

    /**
     * The size of the button.
     *
     * @var string
     **/
    public $size;

    /**
     * The link to which the button should navigate.
     *
     * @var string
     **/
    public $link;

    /**
     * Whether the link is an external link.
     *
     * @var bool
     **/
    public $external;


    /**
     * Whether the button is disabled.
     *
     * @var bool
     **/
    public $disabled;

    /**
     * Whether the button should take up the full width of the container.
     *
     * @var bool
     **/
    public $fullWidth;

    /**
     * The variant of the button.
     *
     * @var string
     **/
    public $variant;

    /**
     * The type of the button.
     *
     * @var string
     **/
    public $type;

    /**
     * The on-click event handler for the button.
     *
     * @var string
     **/
    public $event;

    /**
     * Create a new component instance for the button.
     * 
     * The constructor accepts the following parameters:
     * 
     * @param  string  $text The text content of the component.
     * @param  string|null  $link The link URL associated with the component (optional).
     * @param  string|null  $type The type of component (optional, default is 'button').
     * @param  bool  $disabled Whether the component is disabled (optional, default is false).
     * @param  bool  $fullWidth Whether the component should have full width (optional, default is false).
     * @param  string  $variant The variant style of the component (optional, default is 'contain').
     * @param  string  $size The size of the component (optional, default is 'default').
     * @param  string  $color The color of the component (optional, default is 'primary').
     * @param  bool  $external Whether the link is external (optional, default is false).
     * 
     * @return void
     **/
    public function __construct(
        $link = null,
        $type = null,
        $event = null,
        $disabled = false,
        $fullWidth = false,
        $variant = 'contain',
        $size = 'default',
        $color = 'primary',
        $external = false,
    ) {
        $this->link = $link;
        $this->event = $event;
        $this->type = $type ?? 'button';
        $this->disabled = $disabled;
        $this->fullWidth = $fullWidth;
        $this->variant = $variant;
        $this->size = $size;
        $this->color = $color;
        $this->external = $external;
    }

    /**
     * Get the color styles based on the configured color in the Tailwind CSS configuration.
     *
     * @return string The generated color styles for the UI element.
     */
    public function getColorStyles()
    {
        // Define a mapping of your button colors to Tailwind CSS classes.
        $colorMapping = [
            'primary' => 'bg-primary text-light',
            'secondary' => 'bg-secondary text-light',
            'success' => 'bg-success text-light',
            'danger' => 'bg-danger text-light',
            'warning' => 'bg-warning text-light',
            'info' => 'bg-info text-light',
            'light' => 'bg-light text-dark',
            'dark' => 'bg-dark text-light',
        ];

        // Get the style based on the color and variant
        $baseStyle = $colorMapping[$this->color] ?? 'bg-transparent text-black';

        // Variant-specific adjustments
        if ($this->variant === 'contain') {
            return "bg-{$this->color} text-light ";
        } elseif ($this->variant === 'outline') {
            return "bg-transparent border border-{$this->color} text-{$this->color} ";
        } elseif ($this->variant === 'text') {
            return "bg-transparent text-{$this->color} border-none ";
        }

        // Return the generated color styles
        return $baseStyle;
    }

    /**
     * Get the size styles based on the configured size in the Tailwind CSS configuration.
     *
     * @return string The generated size styles for the UI element.
     */
    public function getSizeStyles()
    {
        // Define a mapping of your button sizes to Tailwind CSS padding and text size classes.
        $sizeMapping = [
            'small' => 'px-2 py-0.5 text-xs',
            'default' => 'px-4 py-1 text-sm',
            'large' => 'px-6 py-2 text-base',
        ];

        // Get the style based on the size
        $sizeStyles = $sizeMapping[$this->size] ?? 'px-4 py-1 text-sm';

        // Return the generated size styles
        return $sizeStyles;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     **/
    public function render()
    {
        return view(
            'giraffeui::button',
            [
                'colorStyles' => $this->getColorStyles(),
                'sizeStyles' => $this->getSizeStyles(),
            ]
        );
    }
}
