# Resource Manager component for Yii 2

[![Latest Version](https://img.shields.io/github/tag/2amigos/yii2-resource-manager-component.svg?style=flat-square&label=release)](https://github.com/2amigos/yii2-resource-manager-component/tags)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/2amigos/yii2-resource-manager-component/master.svg?style=flat-square)](https://travis-ci.org/2amigos/yii2-resource-manager-component)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/2amigos/yii2-resource-manager-component.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-resource-manager-component/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/2amigos/yii2-resource-manager-component.svg?style=flat-square)](https://scrutinizer-ci.com/g/2amigos/yii2-resource-manager-component)
[![Total Downloads](https://img.shields.io/packagist/dt/2amigos/yii2-resource-manager-component.svg?style=flat-square)](https://packagist.org/packages/2amigos/yii2-resource-manager-component)

This extension allows you to manage resources. Currently supports two possible scenarios:

- Resources to save/or saved on a server's folder
- Resources to save/or saved on an Amazon S3 bucket

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require 2amigos/yii2-resource-manager-component:~1.0
```

or add

```
"2amigos/yii2-resource-manager-component": "~1.0"
```

to the `require` section of your `composer.json` file.

## Configuring

Configure the selected component on your configuration file as follows:

```
// For this example we using AmazonS3ResourceManager component
// ...
'components' => [
	// ...
	'resourceManager' => [
	'class' => 'dosamigos\resourcemanager\AmazonS3ResourceManager',
		'key' => 'YOUR-AWS-KEY-HERE',
		'secret' => 'YOUR-AWS-SECRET-HERE',
		'bucket' => 'YOUR-AWS-BUCKET-NAME-HERE'
	]
	// ...
]
// ...
```

Done... Now, to save a resource to AWS S3 server, we just need to do the following:

```
// Defensive code checks not written for the example
$resource = yii\web\UploadedFile::getInstanceByName('instance-name');
$name = md5($resource->name) . '.' . $resource->getExtension();
if(\Yii::$app->resourceManager->save($resource, $name)) {
    echo 'Done...';
}

```

## Testing

```bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Antonio Ramirez](https://github.com/tonydspaniard)
- [Alexander Kochetov](https://github.com/creocoder)
- [All Contributors](https://github.com/2amigos/yii2-resource-manager-component/graphs/contributors)

## License

The BSD License (BSD). Please see [License File](LICENSE.md) for more information.

<blockquote>
    <a href="http://www.2amigos.us"><img src="http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png"></a><br>
    <i>web development has never been so fun</i><br>
    <a href="http://www.2amigos.us">www.2amigos.us</a>
</blockquote>
