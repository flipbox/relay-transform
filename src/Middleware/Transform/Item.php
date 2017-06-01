<?php

/**
 * @copyright  Copyright (c) Flipbox Digital Limited
 * @license    https://github.com/flipbox/relay-transform/blob/master/LICENSE
 * @link       https://github.com/flipbox/relay-transform
 */

namespace Flipbox\Relay\Middleware\Transform;

use Flipbox\Transform\Factory as TransformFactory;

/**
 * @author Flipbox Factory <hello@flipboxfactory.com>
 * @since 1.0.0
 */
class Item extends AbstractResource
{
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
}
