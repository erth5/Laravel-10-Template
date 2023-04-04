<?php

namespace App;

use Illuminate\Routing\ResourceRegistrar as BaseResourceRegistrar;

class ResourceRegistrar extends BaseResourceRegistrar
{
    protected $resourceDefaults = [
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
        'list',
        'importCSV',
        'importExcel',
        'exportCSV',
        'exportExcel',
        'truncate',
    ];

    /**
     * Add the list method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    public function addResourceList($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/all';
        $action = $this->getResourceAction($name, $controller, 'list', $options);
        return $this->router->get($uri, $action);
    }

    /**
     * Add exports and imports to the Ressources
     *
     * @param [string] $name
     * @param [string] $base
     * @param [string] $controller
     * @param [string] $options
     * @return void
     */
    public function addResourcePing($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/ping';
        $action = $this->getResourceAction($name, $controller, 'ping', $options);
        return $this->router->get($uri, $action);
    }

    public function addResourceImportCSV($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/import/csv';
        $action = $this->getResourceAction($name, $controller, 'importCSV', $options);
        return $this->router->post($uri, $action);
    }
    public function addResourceImportExcel($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/import/excel';
        $action = $this->getResourceAction($name, $controller, 'importExcel', $options);
        return $this->router->post($uri, $action);
    }

    public function addResourceExportCSV($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/export/csv';
        $action = $this->getResourceAction($name, $controller, 'exportCSV', $options);
        return $this->router->get($uri, $action);
    }
    public function addResourceExportExcel($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/export/excel';
        $action = $this->getResourceAction($name, $controller, 'exportExcel', $options);
        return $this->router->get($uri, $action);
    }

    public function addResourceTruncate($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name) . '/table/truncate';
        $action = $this->getResourceAction($name, $controller, 'truncate', $options);
        return $this->router->get($uri, $action);
    }
}
