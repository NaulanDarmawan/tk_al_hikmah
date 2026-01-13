<?php

class App
{
    // Kita set default controller ke 'Siswa' (sesuai request Anda sebelumnya)
    protected $controller = 'Siswa';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL(); // $url sekarang dijamin adalah array

        // 1. Controller
        // PERBAIKAN: Cek dulu apakah $url[0] ada (isset)
        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // 2. Method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // 3. Params
        // PERBAIKAN: Gunakan array_values untuk re-index array
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        // Jalankan controller & method, serta kirimkan params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }

        // PERBAIKAN: Jika $_GET['url'] tidak ada, return array kosong
        return [];
    }
}
