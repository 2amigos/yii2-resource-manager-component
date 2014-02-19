Resource Manager component for Yii 2
===========================

This extension allows you to manage resources. Currently supports two possible scenarios: 

- Resources to save/or saved on a server's folder
- Resources to save/or saved on an Amazon S3 bucket



Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require 2amigos/yii2-resource-manager-component "*"
```

or add

```json
"2amigos/yii2-resource-manager-component": "*"
```

to the require section of your `composer.json` file.

Configuring
--------------------------

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

Notes
-----

Looking for a version for the Yii 1.1? There is dedicated repository for it:
[2amigos/resource-manager](https://github.com/2amigos/resource-manager).

> [![2amigOS!](http://www.gravatar.com/avatar/55363394d72945ff7ed312556ec041e0.png)](http://www.2amigos.us)  
<i>Web development has never been so fun!</i>
[www.2amigos.us](http://www.2amigos.us)
