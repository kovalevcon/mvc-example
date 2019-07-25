<?php
declare(strict_types=1);
namespace App\Core;

use App\Core\Database\Database;
use App\Core\Database\PDOConnection;
use App\Core\Exceptions\CoreException;
use App\Core\Exceptions\Handler;
use App\Core\Http\Request;
use App\Core\Http\ResponseJson;
use App\Core\Traits\Singleton;
use Exception;
use PDOException;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class Application
 *
 * @package App\Core
 */
final class Application
{
    use Singleton;

    /** @var array $modules */
    private $modules = [
        'request',
        'response',
        'router',
        'configs',
        'database'
    ];

    /** @var \App\Core\Http\Request $request */
    protected $request;
    /** @var \App\Core\Http\ResponseJson $response */
    protected $response;
    /** @var \App\Core\Router */
    protected $router;
    /** @var \App\Core\Configs $configs */
    protected $configs;
    /** @var \App\Core\Database\Database $database */
    protected $database;

    /**
     * Configure application
     *
     * @throws \Exception
     */
    public function config(): void
    {
        try {
            $this->configs = new Configs('/../../config');
            $this->database = $this->getDatabase();
        } catch (Exception $e) {
            var_dump($e->getMessage(), $e->getFile(), $e->getLine());
            throw new CoreException('System error: error while configure application.');
        }
    }

    /**
     * Run application
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function run(): JsonResponse
    {
        try {
            $this->request = new Request;
            $this->router = (new Router)->parse($this->request);
            return (new Dispatcher($this->router))->dispatch();
        } catch (Exception $e) {
            return ResponseJson::errorResponse($e);
        }
    }

    /**
     * Dispatch module by name
     *
     * @param string $module
     * @return mixed
     * @throws \App\Core\Exceptions\CoreException
     */
    public function dispatch(string $module)
    {
        if (!in_array($module, $this->modules)) {
            throw new CoreException("Module `{$module}` not found in application.");
        }

        return $this->$module;
    }

    /**
     * Get database model
     *
     * @return \App\Core\Database\Database
     * @throws \Exception
     */
    private function getDatabase(): Database
    {
        if (is_null($this->database)) {
            try {
                return new Database(PDOConnection::getInstance($this->configs->get('database')));
            } catch (PDOException $e) {
                Handler::handle($e);
            }
        }

        return $this->database;
    }
}
