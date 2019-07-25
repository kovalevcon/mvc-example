<?php
declare(strict_types=1);
namespace App\Core;

use App\Core\Exceptions\ControllerException;
use App\Core\Interfaces\ControllerRepository;
use App\Core\Interfaces\ServiceRepository;

/**
 * Class Controller
 *
 * @package App\Core
 */
abstract class Controller implements ControllerRepository
{
    /** @var array $services */
    protected $services = [];

    /**
     * Controller constructor.
     *
     * @param array $services
     */
    public function __construct(array $services)
    {
        $this->services = $services;
    }

    /**
     * Get service by name
     *
     * @param string $name
     * @return ServiceRepository
     * @throws \App\Core\Exceptions\ControllerException
     */
    public function getService(string $name): ServiceRepository
    {
        if (!isset($this->services[$name])) {
            throw new ControllerException('System error: service not found for controller.');
        }

        return $this->services[$name];
    }
}
