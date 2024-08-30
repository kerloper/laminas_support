<?php

namespace Support\Handler\Api\Item;

use Laminas\Diactoros\Response\JsonResponse;
use Support\Service\SupportService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ItemUpdateHandler implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    protected ResponseFactoryInterface $responseFactory;

    /** @var StreamFactoryInterface */
    protected StreamFactoryInterface $streamFactory;

    /** @var SupportService */
    protected SupportService $supportService;


    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface   $streamFactory,
        SupportService           $supportService
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->supportService = $supportService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get request body
        $account = $request->getAttribute('account');
        $requestBody = $request->getParsedBody();
        $requestBody['type'] = 'support';
        $requestBody["user_id"] =  $account['id'];
        $result = $this->supportService->updateItem($requestBody,$account);
        $result = [
            'result' => true,
            'data' => $result,
            'error' => []
        ];
        return new JsonResponse($result);
    }
}