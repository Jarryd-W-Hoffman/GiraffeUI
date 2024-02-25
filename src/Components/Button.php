<?php

namespace JayAitch\GiraffeUI\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $link;
    public $type;
    public $classes;
    public $disabled;
    public $color;
public $size;
public $fullscreen;

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
    public function __construct($text, $link = null, $type = null, $classes = [], $disabled = false, $color = 'primary', $size = 'medium', $fullscreen = false)
    {
        $this->text = $text;
        $this->link = $link;
        $this->type = $type ?? 'button';
        $this->classes = $this->prepareClasses($classes, $color, $size, $fullscreen);
        $this->disabled = $disabled;
    }
    

    private function prepareClasses($classes)
    {
        // Add color classes based on component properties
        $colorClasses = [
            'primary' => 'bg-blue-500 text-white',
            'secondary' => 'bg-gray-300 text-black',
            'success' => 'bg-green-500 text-white',
            'warning' => 'bg-yellow-500 text-black',
            'error' => 'bg-red-500 text-white',
        ];
    
        // Add size classes based on component properties
        $sizeClasses = [
            'small' => 'px-2 py-1 text-sm',
            'medium' => 'px-4 py-2 text-base',
            'large' => 'px-6 py-3 text-lg',
        ];
    
        // Add fullscreen class based on component property
        $fullscreenClass = $this->fullscreen ? 'full-screen' : '';
    
        // Merge all classes
        $classes = array_merge(
            $classes,
            $this->link ? $colorClasses['primary'] : $colorClasses['secondary'],
            $sizeClasses[$this->size] ?? $sizeClasses['medium'],
            $fullscreenClass
        );
    
        return $classes;
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
