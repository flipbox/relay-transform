# Relay - Transform
[![Latest Version](https://img.shields.io/github/release/flipbox/relay-transform.svg?style=flat-square)](https://github.com/flipbox/relay-transform/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/flipbox/relay-transform/master.svg?style=flat-square)](https://travis-ci.org/flipbox/relay-transform)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/flipbox/relay-transform.svg?style=flat-square)](https://scrutinizer-ci.com/g/flipbox/relay-transform/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/flipbox/relay-transform.svg?style=flat-square)](https://scrutinizer-ci.com/g/flipbox/relay-transform)
[![Total Downloads](https://img.shields.io/packagist/dt/flipboxdigital/relay-transform.svg?style=flat-square)](https://packagist.org/packages/flipboxdigital/relay-transform)

This package provides a Transform Middleware leveraging [Transform](https://github.com/flipbox/transform) and [Stash](https://github.com/tedious/Stash).

## Installation

To install, use composer:

```
composer require flipboxdigital/relay-transform
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Usage

```php

$request = new Zend\Diactoros\Request();
$response = new Zend\Diactoros\Response();

$data = [
    'firstName' => 'foo',
    'lastName' => 'bar',
    'dateCreated' => new \DateTime(),
    'dateUpdated' => new \DateTime()
];

$queue = [
    [
        'class' => Flipbox\Relay\Middleware\Transform\Item::class,
        'data' => $data,
        'transformer' => function($data) {
            return [
                'name' => [
                    'first' => $data['firstName'],
                    'last' => $data['firstName']
                ],
                'date' => [
                    'created' => $data['dateCreated']->format('c'),
                    'updated' => $data['dateUpdated']->format('c')
                ]
            ]
        }
    ]
];

// Relay runner
$runner = new Runner(
    $queue,
    RelayHelper::createResolver()
);

// Relay runner
$runner = new Relay\Runner(
    $queue,
    Flipbox\Relay\Helpers\RelayHelper::createResolver()
);

// Run
$response = $runner($request, $response);

```

## Contributing

Please see [CONTRIBUTING](https://github.com/flipbox/relay-transform/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Flipbox Digital](https://github.com/flipbox)

## License

The MIT License (MIT). Please see [License File](https://github.com/flipbox/relay-transform/blob/master/LICENSE) for more information.
