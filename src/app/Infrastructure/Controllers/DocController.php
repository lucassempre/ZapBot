<?php

namespace App\Infrastructure\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class DocController extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function files(Filesystem $files, Request $request): Response
    {
        $contents = "";
        $file = 'openapi.json';

        if($request->route('file') == 'postman') $file = 'postman.json';;
        $path = base_path( 'app/docs/'.$file);
        if ($files->exists($path)) $contents = $files->get($path);

        return response($contents)->header('Content-Type', 'application/json');
    }
    public function swagger()
    {
        return view('swagger', [
            'jsBundle' => __DIR__.'/../../../resources/js/swagger/swagger-ui-bundle.js',
            'jsStandalone' => __DIR__.'/../../../resources/js/swagger/swagger-ui-standalone-preset.js',
            'cssUi' => __DIR__.'/../../../resources/css/swagger/swagger-ui.css',
            'url' => route('doc.file', ['swagger']),
        ]);
    }

    public function redoc()
    {
        return view('redoc', [
            'jsStandalone' => __DIR__.'/../../../resources/js/redoc/redoc.standalone.js',
            'url' => route('doc.file', ['redoc']),
        ]);
    }
}
