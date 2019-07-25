<?php
declare(strict_types=1);
namespace App\Core\Http;

use App\Core\Traits\RequestUtils;
use \Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Class Request
 *
 * @package App\Core\Http
 */
class Request extends SymfonyRequest
{
    use RequestUtils;

    /** @var SymfonyRequest $symfonyRequest  */
    public $symfonyRequest;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->symfonyRequest = SymfonyRequest::createFromGlobals();
    }

    /**
     * Get json body as array
     *
     * @return array
     * @throws \Exception
     */
    public function getJsonBody(): array
    {
        return strpos($this->symfonyRequest->headers->get('Content-Type'), 'application/json') === 0 ?
            $this->safetyUserData(json_decode($this->symfonyRequest->getContent(), true)) ?? [] : []
        ;
    }
}
