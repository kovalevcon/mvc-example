<?php
declare(strict_types=1);
namespace Core;

/**
 * Class Controller
 *
 * @package Core
 */
abstract class Controller implements ControllerRepository
{
    /** @var ServiceRepository $service */
    protected $service;

    /**
     * Controller constructor.
     *
     * @param ServiceRepository $service
     */
    public function __construct(ServiceRepository $service)
    {
        $this->service = $service;
    }
}
