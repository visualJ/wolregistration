<?php
namespace BenediktRinglein\Wolregistration\Domain\Model;

	/***************************************************************
	 *
	 *  Copyright notice
	 *
	 *  (c) 2016 Benedikt Ringlein <benedikt.ringlein@aoe.com>, AOE
	 *
	 *  All rights reserved
	 *
	 *  This script is part of the TYPO3 project. The TYPO3 project is
	 *  free software; you can redistribute it and/or modify
	 *  it under the terms of the GNU General Public License as published by
	 *  the Free Software Foundation; either version 3 of the License, or
	 *  (at your option) any later version.
	 *
	 *  The GNU General Public License can be found at
	 *  http://www.gnu.org/copyleft/gpl.html.
	 *
	 *  This script is distributed in the hope that it will be useful,
	 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
	 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	 *  GNU General Public License for more details.
	 *
	 *  This copyright notice MUST APPEAR in all copies of the script!
	 ***************************************************************/

/**
 * A WoL system user
 */
class User extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

	/**
	 * loginName
	 *
	 * @var string
	 */
	protected $loginName = '';

	/**
	 * A user can have one or more devices
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BenediktRinglein\Wolregistration\Domain\Model\Device>
	 * @cascade remove
	 */
	protected $devices = NULL;

	/**
	 * Returns the loginName
	 *
	 * @return string $loginName
	 */
	public function getLoginName()
	{
		return $this->loginName;
	}

	/**
	 * Sets the loginName
	 *
	 * @param string $loginName
	 * @return void
	 */
	public function setLoginName($loginName)
	{
		$this->loginName = $loginName;
	}

	/**
	 * __construct
	 */
	public function __construct()
	{
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all ObjectStorage properties
	 * Do not modify this method!
	 * It will be rewritten on each save in the extension builder
	 * You may modify the constructor of this class instead
	 *
	 * @return void
	 */
	protected function initStorageObjects()
	{
		$this->devices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
	}

	/**
	 * Adds a Device
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\Device $device
	 * @return void
	 */
	public function addDevice(\BenediktRinglein\Wolregistration\Domain\Model\Device $device)
	{
		$this->devices->attach($device);
	}

	/**
	 * Removes a Device
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\Device $deviceToRemove The Device to be removed
	 * @return void
	 */
	public function removeDevice(\BenediktRinglein\Wolregistration\Domain\Model\Device $deviceToRemove)
	{
		$this->devices->detach($deviceToRemove);
	}

	/**
	 * Returns the devices
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BenediktRinglein\Wolregistration\Domain\Model\Device> $devices
	 */
	public function getDevices()
	{
		return $this->devices;
	}

	/**
	 * Sets the devices
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\BenediktRinglein\Wolregistration\Domain\Model\Device> $devices
	 * @return void
	 */
	public function setDevices(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $devices)
	{
		$this->devices = $devices;
	}

	/**
	 * Checks, whether the user has a device with a specific mac address
	 * @param $macAddress string the mac address to check for
	 * @return bool ture, if the user has a device with the specified mac address,
	 *    otherwise false
	 */
	public function hasDeviceWithMacAddress($macAddress)
	{
		foreach ($this->getDevices() as $device) {
			if ($device->getMacAddress() == $macAddress) {
				return true;
			}
		}
		return false;
	}

}