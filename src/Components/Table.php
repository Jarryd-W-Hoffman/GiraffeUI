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
    public $columns;

    /**
     * The items to be displayed in the table.
     *
     * @var array
    **/
    public $rows;

    /**
     * Create a new component instance.
     *
     * @param array $headers
     * @param array $items
    **/
    public function __construct($columns, $rows)
    {
        $this->columns = $columns;
        $this->rows = $rows;
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
