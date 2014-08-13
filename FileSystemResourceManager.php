<?php
/**
 * @link http://2amigos.us
 * @copyright Copyright (c) 2013 2amigOS! Consulting Group LLC
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\resourcemanager;

use yii\helpers\ArrayHelper;
use yii\base\Component;
use Yii;

/**
 *
 * FileSystemResourceManager handles resource to upload/uploaded to a server folder.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
class FileSystemResourceManager extends Component implements ResourceManagerInterface
{
	private $_basePath = '@webroot/uploads';
	private $_baseUrl = '@web/uploads';

	/**
	 * Saves a file
	 * @param \yii\web\UploadedFile $file the file uploaded
	 * @param string $name the name of the file. If empty, it will be set to the name of the uploaded file
	 * @param array $options to save the file. The options can be any of the following:
	 *  - `folder` : whether we should create a subfolder where to save the file
	 *  - `override` : whether we allow rewriting a existing file
	 * @return boolean
	 */
	public function save($file, $name, $options = [])
	{
		$name = ltrim($name, DIRECTORY_SEPARATOR);
		
		if ($folder = trim(ArrayHelper::getValue($options, 'folder'), DIRECTORY_SEPARATOR)) {
			$name = $folder . DIRECTORY_SEPARATOR . $name;
		}
		
		if (!ArrayHelper::getValue($options, 'override', true) && $this->fileExists($name)) {
			return false;
		}
		
		$path = $this->getBasePath() . DIRECTORY_SEPARATOR . $name;
		@mkdir(dirname($path), 0777, true);

		return $file->saveAs($path);
	}

	/**
	 * Removes a file
	 * @param string $name the name of the file to remove
	 * @return boolean
	 */
	public function delete($name)
	{
		return $this->fileExists($name) ? @unlink($this->getBasePath() . DIRECTORY_SEPARATOR . $name) : false;
	}

	/**
	 * Checks whether a file exists or not
	 * @param string $name the name of the file
	 * @return boolean
	 */
	public function fileExists($name)
	{
		return file_exists($this->getBasePath() . DIRECTORY_SEPARATOR . $name);
	}

	/**
	 * Returns the url of the file or empty string if the file doesn't exist.
	 * @param string $name the name of the file
	 * @return string
	 */
	public function getUrl($name)
	{
		return $this->getBaseUrl() . '/' . $name;
	}

	/**
	 * Returns the upload directory path
	 * @return string
	 */
	public function getBasePath()
	{
		return Yii::getAlias($this->_basePath);
	}

	/**
	 * Sets the upload directory path
	 * @param $value
	 */
	public function setBasePath($value)
	{
		$this->_basePath = rtrim($value, DIRECTORY_SEPARATOR);
	}

	/**
	 * Returns the base url
	 * @return string the url pointing to the directory where we saved the files
	 */
	public function getBaseUrl()
	{
		return Yii::getAlias($this->_baseUrl);
	}

	/**
	 * Sets the base url
	 * @param string $value the url pointing to the directory where to get the files
	 */
	public function setBaseUrl($value)
	{
		$this->_baseUrl = rtrim($value, '/');
	}
}
