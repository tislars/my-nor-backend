<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public array $headers;
    public array $rows;
    public string $emptyMessage;

    /**
     * Create a new component instance.
     *
     * @param array $headers
     * @param array $rows
     * @param string $emptyMessage
     */
    public function __construct(array $headers, array $rows, string $emptyMessage = 'No data available.')
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->emptyMessage = $emptyMessage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.table');
    }
}
