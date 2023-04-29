<?php
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            array_shift($url);
        }

        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;


        if (isset($url[0])) {
            if (method_exists($this->currentController, $url[0])) {
                $this->currentMethod = $url[0];
                array_shift($url);
            } else {
                $this->currentController = 'Pages';
                require_once '../app/controllers/' . $this->currentController . '.php';
                $this->currentController = new $this->currentController;
                call_user_func_array([$this->currentController, "page404"], $this->params);
                die();
            }
        }

        $this->params = $url ? array_values($url) : [];

        try {
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        } catch (ArgumentCountError $e) {
            $this->currentController = 'Pages';
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController;
            call_user_func_array([$this->currentController, "page500"], $this->params);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
