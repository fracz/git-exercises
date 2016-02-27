<?php
namespace GitExercises\services;

use Slim\Http\Response;

class JsonHelper
{
    public static function setResponse(Response $response, $content, $status = 200)
    {
        $response->headers->set('Content-Type', 'application/json');
        $response->setStatus($status);
        $content = self::prepareDataToSend($content);
        $response->write(self::toJson($content));
    }

    public static function toJson($content)
    {
        return ")]}',\n" . json_encode($content);
    }

    private static function prepareDataToSend($content)
    {
        if (is_object($content)) {
            $content = get_object_vars($content);
        }
        if (is_array($content)) {
            if (isset($content['password'])) {
                unset($content['password']);
            }
            foreach ($content as $name => $value) {
                if (preg_match('#^(ha|i)s[A-Z_]#', $name) && ($value == '0' || $value == '1')) {
                    $content[$name] = (bool)$value;
                } else if (is_array($value) || is_object($value)) {
                    $content[$name] = self::prepareDataToSend($value);
                }
            }
        }
        return $content;
    }
}
