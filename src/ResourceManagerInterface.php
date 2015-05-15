<?php
/**
 * @link https://github.com/2amigos/yii2-resource-manager-component
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace dosamigos\resourcemanager;

 /**
 *
 * Interface ResourceManagerInterface defines a set of methods to be implemented by a [[ResourceManager]]
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 */
interface ResourceManagerInterface
{
	/**
	 * Saves a file
	 * @param \yii\web\UploadedFile $file the file uploaded
	 * @param string $name the name of the file
	 * @param array $options
	 * @return boolean
	 */
	public function save($file, $name, $options = []);

	/**
	 * Removes a file
	 * @param string $name the name of the file to remove
	 * @return boolean
	 */
	public function delete($name);

	/**
	 * Checks whether a file exists or not
	 * @param string $name the name of the file
	 * @return boolean
	 */
	public function fileExists($name);

	/**
	 * Returns the url of the file or empty string if the file doesn't exist.
	 * @param string $name the name of the file
	 * @return string
	 */
	public function getUrl($name);

}
