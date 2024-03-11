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
     * The text content of the button.
     *
     * @var string
    **/
    public $text;
    
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
     * The custom content to be displayed on the left side of the button.
     * 
     * @var string
    **/
    public $customLeft;

    /**
     * The custom content to be displayed on the right side of the button.
     * 
     * @var string
    **/
    public $customRight;

    /**
     * Create a new component instance.
     *
     * @param  string  $text
     * @param  string|null  $link
     * @param  string|null  $type
     * @param  array  $classes
     * @param  bool  $disabled
     * @return void
     */
    public function __construct($text, $link = null, $type = null, $disabled = false, $fullWidth = false, $variant = 'contain', $size = 'default', $color = 'primary', $external = false, $customLeft = null, $customRight = null)
    {
        $this->text = $text;
        $this->link = $link;
        $this->type = $type ?? 'button';
        $this->disabled = $disabled;
        $this->fullWidth = $fullWidth;
        $this->variant = $variant;
        $this->size = $size;
        $this->color = $color;
        $this->external = $external;
        $this->customLeft = $customLeft;
        $this->customRight = $customRight;
    }

    /**
     * Get the color styles based on the configured color in the GiraffeUI.
     *
     * @return string The generated color styles for the UI element.
    **/
    public function getColorStyles()
    {
        // Retrieve the configured colors from the GiraffeUI configuration file.
        $colors = config('giraffeui.colors');

        // Get the color configuration for the specific color, if available.
        $colorConfig = $colors[$this->color] ?? null;

        if ($colorConfig && is_array($colorConfig)) {
            // Extract base color, shade, opacity, and text color from the configuration.
            $baseColor = $colorConfig['base']['color'] ?? 'blue';
            $shade = $colorConfig['base']['shade'] ?? '500';
            $opacity = $colorConfig['base']['opacity'] ?? null;
            $textColor = $colorConfig['text_color'] ?? 'black';

            if ($baseColor) {
                // Construct the base style with color, shade, and optional opacity.
                $opacitySuffix = $opacity !== null ? "/{$opacity}" : '';
                $baseStyle = "bg-{$baseColor}-{$shade}{$opacitySuffix}";

                // Variant-specific adjustments
                if ($this->variant === 'contain') {
                    // Adjust background color for contained variant
                    $baseStyle = "bg-{$baseColor}-{$shade}{$opacitySuffix} text-{$textColor}";
                } elseif ($this->variant === 'outline') {
                    // Adjust border color for outlined variant
                    $baseStyle = "bg-transparent text-{$baseColor}-${shade}{$opacitySuffix} border border-{$baseColor}-{$shade}{$opacitySuffix}";
                } elseif ($this->variant === 'text') {
                    // Adjust text color for text variant
                    $baseStyle = "bg-transparent text-{$baseColor}-{$shade}{$opacitySuffix} border-none";
                }

                // Return the generated color styles including background and text colors.
                return "{$baseStyle} ";
            }
        }

        // If color configuration is not available, return the original color.
        return $this->color;
    }

    public function getSizeStyles()
    {
        // Retrieve the size settings from the configuration file
        $sizes = config('giraffeui.sizes');

        // Get the size configuration for the specific size, if available.
        $sizeConfig = $sizes[$this->size] ?? null;

        if ($sizeConfig && is_array($sizeConfig)) {
            // Extract horizontal spacing, vertical spacing, and text size from the configuration.
            $horizontalSpacing = $sizeConfig['horizontal_spacing'] ?? '4';
            $verticalSpacing = $sizeConfig['vertical_spacing'] ?? '2';
            $textSize = $sizeConfig['text_size'] ?? 'sm';

            if ($horizontalSpacing) {
                // Construct the size styles with horizontal and vertical spacing, and text size.
                $sizeStyles = "px-{$horizontalSpacing} py-{$verticalSpacing} text-{$textSize}";

                // Return the generated size styles including horizontal and vertical spacing, and text size.
                return "$sizeStyles ";
            }
        }

        return $this->size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
    **/
    public function render()
    {
        return view('giraffeui::button', 
            [
                'colorStyles' => $this->getColorStyles(),
                'sizeStyles' => $this->getSizeStyles(),
            ]
        );
    }
}
