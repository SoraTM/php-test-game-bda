<?php

namespace game;

class Renderer
{
    private $view;
    private $params;

    public function __construct($view, $params)
    {
        $this->view = (__DIR__ . "/views/" . $view . ".phtml");
        $this->params = $params;
    }

    //render view using params, params must be assoc array.

    public function render()
    {
        extract($this->params);
        ob_start();
        include($this->view);
        return ob_get_clean();
    }
}
