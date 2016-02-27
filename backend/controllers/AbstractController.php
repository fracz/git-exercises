<?php

namespace GitExercises\controllers;

use Exception;
use GitExercises\services\HasApp;
use GitExercises\services\JsonHelper;
use Slim\Exception\Stop;

abstract class AbstractController
{
    use HasApp;

    private $requestBody;

    protected function getRequestBody()
    {
        return $this->requestBody;
    }

    protected function getFromRequest($name, $default = null)
    {
        return array_key_exists($name, $this->requestBody) ? $this->requestBody[$name] : $default;
    }

    protected function getParam($name, $defaultValue = null)
    {
        return $this->getApp()->request()->params($name, $defaultValue);
    }

    protected function hasAccess($resource, $privilege = null)
    {
        return $this->getApp()->acl->isAllowed($resource, $privilege);
    }

    public function __call($methodName, $args)
    {
        $this->requestBody = $this->getApp()->request()->getBody();
        $action = $methodName . 'Action';
        try {
            $result = call_user_func_array([&$this, $action], $args);
            JsonHelper::setResponse($this->getApp()->response(), $result);
        } catch (Stop $e) { // list here exceptions that should not be caught
            throw $e;
        } catch (Exception $e) {
            error_log($e);
            JsonHelper::setResponse($this->getApp()->response(), [
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}


