<?php

namespace JayAitch\GiraffeUI\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $link;
    public $type;
    public $disabled;
    public $fullWidth;
    public $variant;
    public $size;
    public $color;

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
    public function __construct($text, $link = null, $type = null, $disabled = false, $fullWidth = false, $variant = 'contained', $size = 'medium', $color = 'primary')
    {
        $this->text = $text;
        $this->link = $link;
        $this->type = $type ?? 'button';
        $this->disabled = $disabled;
        $this->fullWidth = $fullWidth;
        $this->variant = $variant;
        $this->size = $size;
        $this->color = $color;
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

                // Return the generated color styles including background and text colors.
                return "{$baseStyle} text-{$textColor}";
            }
        }

        // If color configuration is not available, return the original color.
        return $this->color;
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
            ]
        );
    }
}
