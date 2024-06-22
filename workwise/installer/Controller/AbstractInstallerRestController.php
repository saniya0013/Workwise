<?php

namespace OrangeHRM\Installer\Controller;

use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Framework\Http\Response;
use OrangeHRM\Installer\Exception\MigrationException;
use OrangeHRM\Installer\Exception\NotImplementedException;
use OrangeHRM\Installer\Util\Logger;
use Throwable;

abstract class AbstractInstallerRestController extends AbstractInstallerController
{
    /**
     * @param Request $request
     * @return Response
     * @throws NotImplementedException
     */
    protected function execute(Request $request): Response
    {
        // 'application/json', 'application/x-json'
        if ($request->getContentType() === 'json') {
            if ($request->getContent() !== '') {
                $data = json_decode($request->getContent(), true);
                if (is_array($data)) {
                    $request->request->add($data);
                }
            }
        }

        $response = $this->getResponse();
        $response->headers->set('Content-Type', 'application/json');
        $data = [];
        try {
            switch ($request->getMethod()) {
                case Request::METHOD_GET:
                    $data = $this->handleGet($request);
                    break;

                case Request::METHOD_POST:
                    $data = $this->handlePost($request);
                    break;

                case Request::METHOD_PUT:
                    $data = $this->handlePut($request);
                    break;

                case Request::METHOD_DELETE:
                    $data = $this->handleDelete($request);
                    break;

                default:
                    throw new NotImplementedException();
            }
        } catch (NotImplementedException $e) {
            $response->setStatusCode(Response::HTTP_NOT_IMPLEMENTED);
            $response->setContent(
                json_encode([
                    'error' => [
                        'status' => $response->getStatusCode(),
                        'message' => $e->getMessage(),
                    ]
                ])
            );
            return $response;
        } catch (MigrationException $e) {
            $response->setStatusCode(Response::HTTP_REQUEST_TIMEOUT);
            $response->setContent(
                json_encode([
                    'error' => [
                        'status' => $response->getStatusCode(),
                        'message' => $e->getMessage()
                    ]
                ])
            );
            Logger::getLogger()->error($e->getMessage());
            Logger::getLogger()->error($e->getTraceAsString());
            return $response;
        } catch (Throwable $e) {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent(
                json_encode([
                    'error' => [
                        'status' => $response->getStatusCode(),
                        'message' => 'Unexpected Error',
                    ]
                ])
            );
            Logger::getLogger()->error($e->getMessage());
            Logger::getLogger()->error($e->getTraceAsString());
            return $response;
        }
        $response->setContent(json_encode($data));
        return $response;
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotImplementedException
     */
    protected function handleGet(Request $request): array
    {
        throw new NotImplementedException();
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotImplementedException
     */
    protected function handlePost(Request $request): array
    {
        throw new NotImplementedException();
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotImplementedException
     */
    protected function handlePut(Request $request): array
    {
        throw new NotImplementedException();
    }

    /**
     * @param Request $request
     * @return array
     * @throws NotImplementedException
     */
    protected function handleDelete(Request $request): array
    {
        throw new NotImplementedException();
    }
}
