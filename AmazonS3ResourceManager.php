<?php
/**
 * @link http://2amigos.us
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\resourcemanager;

use Aws\S3\Enum\CannedAcl;
use Aws\S3\S3Client;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Service\Client;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use Yii;

/**
 *
 * AmazonS3ResourceManager handles resources to upload/uploaded to Amazon AWS
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
class AmazonS3ResourceManager extends Component implements ResourceManagerInterface
{

	/**
	 * @var string Amazon access key
	 */
	public $key;
	/**
	 * @var string Amazon secret access key
	 */
	public $secret;
	/**
	 * @var string Amazon Bucket
	 */
	public $bucket;
	/**
	 * @var \Aws\S3\S3Client
	 */
	private $_client;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		foreach (['key', 'secret', 'bucket'] as $attribute) {
			if ($this->$attribute === null) {
				throw new InvalidConfigException(strtr('"{class}::{attribute}" cannot be empty.', [
					'{class}' => static::className(),
					'{attribute}' => '$' . $attribute
				]));
			}
		}
		parent::init();
	}

	/**
	 * Saves a file
	 * @param \yii\web\UploadedFile $file the file uploaded. The [[UploadedFile::$tempName]] will be used as the source
	 * file.
	 * @param string $name the name of the file
	 * @param array $options extra options for the object to save on the bucket. For more information, please visit
	 * [[http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_putObject]]
	 * @return \Guzzle\Service\Resource\Model
	 */
	public function save($file, $name, $options = [])
	{
		$options = ArrayHelper::merge([
			'Bucket' => $this->bucket,
			'Key' => $name,
			'SourceFile' => $file->tempName,
			'ACL' => CannedAcl::PUBLIC_READ // default to ACL public read
		], $options);

		$this->getClient()->putObject($options);
	}
	
	/**
	 * Saves a file
	 * @param string $data the file content
	 * file.
	 * @param string $name the name of the file
	 * @param array $options extra options for the object to save on the bucket. For more information, please visit
	 * [[http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_putObject]]
	 * @return \Guzzle\Service\Resource\Model
	 */
	public function saveBlob($data, $name, $options = [])
	{
	    $options = ArrayHelper::merge([
	            'Bucket' => $this->bucket,
	            'Key' => $name,
	            'Body' => $data,
	            'ACL' => CannedAcl::PUBLIC_READ // default to ACL public read
	            ], $options);
	
	    $this->getClient()->putObject($options);
	}

	/**
	 * Removes a file
	 * @param string $name the name of the file to remove
	 * @return boolean
	 */
	public function delete($name)
	{
		$result = $this->getClient()->deleteObject([
			'Bucket' => $this->bucket,
			'Key' => $name
		]);

		return $result['DeleteMarker'];
	}

	/**
	 * Checks whether a file exists or not. This method only works for public resources, private resources will throw
	 * a 403 error exception.
	 * @param string $name the name of the file
	 * @return boolean
	 */
	public function fileExists($name)
	{
		$http = new \Guzzle\Http\Client();
		try {
			$response = $http->get($this->getUrl($name))->send();
		} catch(ClientErrorResponseException $e) {
			return false;
		}
		return $response->isSuccessful();
	}

	/**
	 * Returns the url of the file or empty string if the file does not exists.
	 * @param string $name the key name of the file to access
	 * @return string
	 */
	public function getUrl($name)
	{
		return $this->getClient()->getObjectUrl($this->bucket, $name);
	}

	/**
	 * Returns a S3Client instance
	 * @return \Aws\S3\S3Client
	 */
	public function getClient()
	{
		if ($this->_client === null) {
			$this->_client = S3Client::factory([
				'key' => $this->key,
				'secret' => $this->secret
			]);
		}
		return $this->_client;
	}
}