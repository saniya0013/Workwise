<?php


namespace OrangeHRM\Installer\Controller;

use InvalidArgumentException;
use OrangeHRM\Config\Config;
use OrangeHRM\Core\Traits\ControllerTrait;
use OrangeHRM\Framework\Http\RedirectResponse;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Framework\Http\Response;

abstract class AbstractInstallerController
{
    use ControllerTrait;

    /**
     * @var Response|RedirectResponse|null
     */
    protected $response = null;

    /**
     * @return Response
     */
    protected function getNewResponse(): Response
    {
        return new Response();
    }

    /**
     * @return Response|RedirectResponse
     */
    protected function getResponse()
    {
        if (!($this->response instanceof Response || $this->response instanceof RedirectResponse)) {
            $this->response = $this->getNewResponse();
        }
        return $this->response;
    }

    /**
     * @param RedirectResponse|Response|null $response
     */
    protected function setResponse($response): void
    {
        if (!($response instanceof Response ||
            $response instanceof RedirectResponse ||
            is_null($response))
        ) {
            throw new InvalidArgumentException(
                'Only allowed null, ' . Response::class . ', ' . RedirectResponse::class
            );
        }

        $this->response = $response;
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function handle(Request $request)
    {
        $ignoredPaths = ['/upgrader/complete', '/installer/complete', '/'];
        if (Config::isInstalled() && !in_array($request->getPathInfo(), $ignoredPaths)) {
            $this->getResponse()->setStatusCode(Response::HTTP_BAD_GATEWAY);
            return $this->getResponse();
        }
        return $this->execute($request);
    }

    /**
     * @param Request $request
     * @return Response|RedirectResponse
     */
    abstract protected function execute(Request $request);
}
