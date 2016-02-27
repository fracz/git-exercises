<?php


namespace GitExercises;

use GitExercises\services\CommiterService;
use GitExercises\services\JsonHelper;
use Slim\Middleware\ContentTypes;
use Slim\Slim;

/**
 * @property \PDO $database
 * @property CommiterService $commiterService
 */
class Application extends Slim
{
    /**
     * Application constructor.
     */
    public function __construct(array $userSettings = [])
    {
        parent::__construct($userSettings);
        $this->addCustomMiddleware();
        $this->setNotFoundHandler();
        $this->configureDatabase();
        $this->injectServices();
    }

    private function addCustomMiddleware()
    {
        $this->add(new ContentTypes());
    }

    private function setNotFoundHandler()
    {
        $this->notFound(function () {
            $notFound = $this->request->getMethod() . ' ' . $this->request->getPath();
            error_log($notFound . ' - address not found (404)');
            echo JsonHelper::toJson([
                'status' => 404,
                'message' => 'Requested resource does not exist.',
            ]);
        });
    }

    private function configureDatabase()
    {
        $this->container->singleton('database', function () {
            return require __DIR__ . '/db.php';
        });
    }

    private function injectServices()
    {
        $this->container->singleton('commiterService', function () {
            return new CommiterService($this->database);
        });
    }
}
