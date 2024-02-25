<?php

namespace JayAitch\GiraffeUI\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $text;
    public $link;
    public $type;
    public $disabled;
    public $classes;

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
    public function __construct($text, $link = null, $type = null, $disabled = false)
    {
        $this->text = $text;
        $this->link = $link;
        $this->type = $type ?? 'button';
        $this->disabled = $disabled;
    }

    public function classes()
    {
        $classes = [
            'bg-blue-500',
            'text-white',
            'font-bold',
            'py-2',
            'px-4',
            'rounded',
        ];

        if ($this->disabled) {
            $classes[] = 'opacity-50';
            $classes[] = 'cursor-not-allowed';
        }

        return $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('giraffeui::button', [
            'classes' => $this->classes(),
        ]);
    }
}
