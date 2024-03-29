<?php

namespace Anax\MVC;

/**
 * A container for routes.
 *
 */
class CDispatcherBasic implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectionAware;



    /**
     * Properties
     *
     */
    private $controller;    // Name of controller
    private $action;        // Name of action
    private $params;        // Params



    /**
     * Prepare the name.
     *
     * @param string $name to prepare.
     *
     * @return string as the prepared name.
     */
    public function prepareName($name)
    {
        $name = empty($name) ? 'index' : $name;
        $name = strtolower($name);
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        
        return $name;
    }



    /**
     * Set the name of the controller.
     *
     * @param string $name of the controller, defaults to 'index'.
     *
     * @return void
     */
    public function setControllerName($name = 'index')
    {
        $name = $this->prepareName($name) . 'Controller';
        
        if ($this->di->has($name)) {
            $this->controller = $this->di->get($name);
        } else {
            throw new \Exception('No such controller available in the service container.');
        }
    }



    /**
     * Set the name of the action.
     *
     * @param string $name of the action, defaults to 'index'.
     *
     * @return void
     */
    public function setActionName($name = 'index')
    {
        $this->action = lcfirst($this->prepareName($name)) . 'Action';
    }



    /**
     * Set the params.
     *
     * @param array $params all parameters, defaults to empty.
     *
     * @return void
     */
    public function setParams($params = [])
    {
        $this->params = $params;
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function isCallable()
    {
        $handler = [$this->controller, $this->action];
        return is_callable($handler);
    }



    /**
     * Dispatch to a controller, action with parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function dispatch()
    {
        $handler = [$this->controller, $this->action];
        return call_user_func_array($handler, $this->params);
    }


    /**
     * Forward to a controller, action with parameters.
     *
     * @param array $forward with details for controller, action, parameters.
     *
     * @return mixed result from dispatched controller action.
     */
    public function forward($forward = [])
    {
        $controller = isset($forward['controller'])  
            ? $forward['controller']
            : null;

        $action = isset($forward['action'])
            ? $forward['action']
            : null;
        
        $params = isset($forward['params'])
            ? $forward['params']
            : [];

        $this->setControllerName($controller);
        $this->setActionName($action);
        $this->setParams($params);

        return $this->dispatch();
    }
}
