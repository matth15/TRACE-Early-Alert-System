<?php

class Controller
{


    /**
     *  Load View
     *  @param string $view
     *  @param array $data
     */


    public function view($view, $data = [])
    {
        if (is_array($data)) {
            extract($data);
        }

        $filename = "app/view/" . $view . ".php";
        if (file_exists($filename)) {
            require $filename;
        }
    }

    /**
     *  Load Model
     *  @param string $model
     */

    public function model($model)
    {

        $filename = "app/model/" . ucfirst($model) . ".php";

        if (file_exists($filename)) {
            require $filename;

            return new $model();
        }
        return false;
    }

    /**
     * Converts characters to HTML entities
     * This is important to avoid XSS attacks, and attempts to inject malicious code in your page.
     *
     * @param  string $str The string.
     * @return string
     */
    public function encodeHTML($str)
    {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}
