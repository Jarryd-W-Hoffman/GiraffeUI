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

    public function getColorStyles()
    {
        $colors = config('giraffeui.colors');
        $colorConfig = $colors[$this->color] ?? null;

        if ($colorConfig && is_array($colorConfig)) {
            $baseColor = $colorConfig['color'] ?? null;
            $shade = $colorConfig['shade'] ?? '500';
            $opacity = $colorConfig['opacity'] ?? null;

            if ($baseColor) {
                $opacitySuffix = $opacity !== null ? "/{$opacity}" : '';
                return "bg-{$baseColor}-{$shade}{$opacitySuffix}";
            }
        }

        return $this->color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('giraffeui::button');
    }
}
