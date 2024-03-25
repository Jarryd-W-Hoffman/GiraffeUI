<?php

namespace JayAitch\GiraffeUI\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * The headers for the table.
     *
     * @var array
    **/
    public $headers;

    /**
     * The items to be displayed in the table.
     *
     * @var array
    **/
    public $items;

    /**
     * Create a new component instance.
     *
     * @param array $headers
     * @param array $items
    **/
    public function __construct($headers, $items)
    {
        $this->headers = $headers;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
    **/
    public function render()
    {
        return view('giraffeui::table');
    }
}
