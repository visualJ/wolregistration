<?php

namespace BenediktRinglein\Wolregistration\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Benedikt Ringlein <benedikt.ringlein@aoe.com>, AOE
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \BenediktRinglein\Wolregistration\Domain\Model\User.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Benedikt Ringlein <benedikt.ringlein@aoe.com>
 */
class UserTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {
	/**
	 * @var \BenediktRinglein\Wolregistration\Domain\Model\User
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = new \BenediktRinglein\Wolregistration\Domain\Model\User();
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getLoginNameReturnsInitialValueForString() {
		$this->assertSame(
			'',
			$this->subject->getLoginName()
		);
	}

	/**
	 * @test
	 */
	public function setLoginNameForStringSetsLoginName() {
		$this->subject->setLoginName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'loginName',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDevicesReturnsInitialValueForDevice() {
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getDevices()
		);
	}

	/**
	 * @test
	 */
	public function setDevicesForObjectStorageContainingDeviceSetsDevices() {
		$device = new \BenediktRinglein\Wolregistration\Domain\Model\Device();
		$objectStorageHoldingExactlyOneDevices = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneDevices->attach($device);
		$this->subject->setDevices($objectStorageHoldingExactlyOneDevices);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneDevices,
			'devices',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addDeviceToObjectStorageHoldingDevices() {
		$device = new \BenediktRinglein\Wolregistration\Domain\Model\Device();
		$devicesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$devicesObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($device));
		$this->inject($this->subject, 'devices', $devicesObjectStorageMock);

		$this->subject->addDevice($device);
	}

	/**
	 * @test
	 */
	public function removeDeviceFromObjectStorageHoldingDevices() {
		$device = new \BenediktRinglein\Wolregistration\Domain\Model\Device();
		$devicesObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$devicesObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($device));
		$this->inject($this->subject, 'devices', $devicesObjectStorageMock);

		$this->subject->removeDevice($device);

	}
}
