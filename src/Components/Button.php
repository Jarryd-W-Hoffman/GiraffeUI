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

    public function getColorClass()
    {
        $colorClasses = [
            'primary' => 'bg-' . config('giraffeui.colors.primary') . ' text-white',
            'secondary' => 'bg-' . config('giraffeui.colors.secondary') . ' text-white',
            'success' => 'bg-' . config('giraffeui.colors.success') . ' text-white',
            'warning' => 'bg-' . config('giraffeui.colors.warning') . ' text-black',
            'info' => 'bg-' . config('giraffeui.colors.info') . ' text-white',
            'danger' => 'bg-' . config('giraffeui.colors.danger') . ' text-white',
            'light' => 'bg-' . config('giraffeui.colors.light') . ' text-black',
            'dark' => 'bg-' . config('giraffeui.colors.dark') . ' text-white',
        ];

        return $colorClasses[$this->color] ?? 'bg-' . config('giraffeui.colors.primary') . '  text-white';
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
