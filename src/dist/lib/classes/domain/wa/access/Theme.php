<?php

namespace Shevsky\Discount4Review\Domain\Wa\Access;

use Shevsky\Discount4Review\Domain\Wa\Env\Env;
use Shevsky\Discount4Review\Domain\Wa\Env\WaEnv;
use Shevsky\Discount4Review\Persistence\Access\IStorefront;
use Shevsky\Discount4Review\Persistence\Access\ITheme;
use Shevsky\Discount4Review\Util\DefineUtil;
use waException;
use waTheme;

class Theme implements ITheme
{
	private $theme;
	private $env;
	private $wa_env;
	private $storefront_ids;

	/**
	 * @param waTheme $theme
	 * @param Env $env
	 * @param WaEnv $wa_env
	 */
	public function __construct(waTheme $theme, Env $env, WaEnv $wa_env)
	{
		$this->theme = $theme;
		$this->env = $env;
		$this->wa_env = $wa_env;
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->theme->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->theme->getName();
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		$description = $this->theme->getDescription();

		return is_string($description) ? $description : '';
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->theme->getUrl();
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->theme->getPath();
	}

	/**
	 * @param string[] $storefront_ids
	 */
	public function setStorefrontIds(array $storefront_ids)
	{
		$this->storefront_ids = $storefront_ids;
	}

	/**
	 * @return string[]
	 */
	public function getStorefrontIds()
	{
		return $this->storefront_ids;
	}

	/**
	 * @return IStorefront[]
	 */
	public function getStorefronts()
	{
		return DefineUtil::getInstance($this->env)->defineStorefronts(...$this->getStorefrontIds());
	}

	/**
	 * @return bool
	 */
	public function hasStorefronts()
	{
		return !empty($this->getStorefrontIds());
	}

	/**
	 * @return array[] = [
	 *  $file => [
	 *      'path' => string,
	 *      'description' => string,
	 *      'is_modified' => bool,
	 *      'is_customized' => bool
	 *  ]
	 * ]
	 */
	public function getFiles()
	{
		$_files = $this->theme->getFiles();
		$files = [];

		foreach ($_files as $path => $_file)
		{
			$files[] = [
				'path' => $path,
				'description' => $_file['description'],
				'is_modified' => (bool)$_file['modified'],
				'is_customized' => (bool)$_file['custom'],
			];
		}

		return $files;
	}

	/**
	 * @param string $path
	 * @return string[] = [
	 *  'path' => string,
	 *  'description' => string,
	 *  'is_modified' => bool,
	 *  'is_customized' => bool
	 * ]
	 */
	public function getFile($path)
	{
		$_file = $this->theme->getFile($path);

		return [
			'path' => $path,
			'description' => $_file['description'],
			'is_modified' => (bool)$_file['modified'],
			'is_customized' => (bool)$_file['custom'],
		];
	}

	/**
	 * @param string $path
	 * @param string $description
	 * @return string
	 */
	public function setFile($path, $description = '')
	{
		if ($this->hasFile($path))
		{
			$this->theme->changeFile($path, $description);
		}
		else
		{
			try
			{
				$this->theme->addFile($path, $description);
			}
			catch (waException $e)
			{

			}
		}
	}

	/**
	 * @param string $path
	 * @return bool
	 */
	public function hasFile($path)
	{
		return !!count($this->theme->getFile($path));
	}

	/**
	 * @param string $path
	 */
	public function removeFile($path)
	{
		try
		{
			$this->theme->removeFile($path);
		}
		catch (waException $e)
		{
		}
	}

	/**
	 * @param string[] $excluded_rows
	 * @return mixed[] = [
	 *  'id' => number,
	 *  'name' => string,
	 *  'description' => string,
	 *  'url' => string,
	 *  'path' => string,
	 *  'storefronts' => array[]
	 * ]
	 */
	public function toArray(array $excluded_rows = [])
	{
		$rows = [
			'id' => $this->getId(),
			'name' => $this->getName(),
			'description' => $this->getDescription(),
			'url' => $this->getUrl(),
		];

		if (!in_array('path', $excluded_rows))
		{
			$rows['path'] = $this->getPath();
		}

		if (!in_array('storefronts', $excluded_rows))
		{
			$rows['storefronts'] = array_map(
				[__CLASS__, 'storefrontToArray'],
				$this->getStorefronts()
			);
		}

		return $rows;
	}

	/**
	 * @param IStorefront $storefront
	 * @return mixed[]
	 */
	private function storefrontToArray(IStorefront $storefront)
	{
		return $storefront->toArray(['Theme']);
	}
}