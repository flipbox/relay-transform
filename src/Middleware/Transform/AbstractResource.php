<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-transform/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-transform
 */

namespace Flipbox\Relay\Middleware\Transform;

use Flipbox\Http\Stream\Factory as StreamFactory;
use Flipbox\Relay\Middleware\AbstractMiddleware;
use Flipbox\Skeleton\Helpers\JsonHelper;
use Flipbox\Transform\Factory as TransformFactory;
use Flipbox\Transform\Helpers\Transformer as TransformerHelper;
use Flipbox\Transform\transformers\TransformerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class AbstractResource extends AbstractMiddleware
{
    /**
     * @var mixed
     */
    public $data;

    /**
     * @var string|callable|TransformerInterface
     */
    public $transformer;

    /**
     * @var array
     */
    public $config = [];

    /**
     * @inheritdoc
     */
    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // Set transformed body contents
        $request = $request->withBody(
            StreamFactory::create(
                JsonHelper::encode($this->transform())
            )
        );

        $response = $next($request, $response);

        return $this->handleResponse($response);
    }

    /**
     * @return array|null
     */
    protected function transform()
    {
        return TransformFactory::item($this->config)
            ->transform(
                $this->resolveTransformer(),
                $this->data
            );
    }

    /**
     * @return callable|TransformerInterface
     * @throws \Exception
     */
    protected function resolveTransformer()
    {
        if (TransformerHelper::isTransformer($this->transformer)) {
            return $this->transformer;
        }

        if (TransformerHelper::isTransformerClass($this->transformer)) {
            return new $this->transformer();
        }

        throw new \Exception("Invalid transformer");
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    protected function handleResponse(ResponseInterface $response)
    {
        return $response;
    }
}
