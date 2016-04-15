<?php
namespace BenediktRinglein\Wolregistration\Tests\Unit\Controller;
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
 * Test case for class BenediktRinglein\Wolregistration\Controller\UserController.
 *
 * @author Benedikt Ringlein <benedikt.ringlein@aoe.com>
 */
class UserControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \BenediktRinglein\Wolregistration\Controller\UserController
	 */
	protected $subject = NULL;

	protected $fe_user = NULL;

	public function setUp()
	{
		$this->fe_user = $this->getMock('TYPO3\\CMS\Extbase\\Domain\\Model\\FrontendUser', array('setKey', 'getKey'), array(), '', FALSE);
		$this->fe_user->method('getKey')->willReturn('dummy');
		$this->subject = $this->getMock('BenediktRinglein\\Wolregistration\\Controller\\UserController', array('redirect', 'forward', 'addFlashMessage', 'listAction'), array($this->fe_user), '', TRUE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenUserToView()
	{
		$user = new \BenediktRinglein\Wolregistration\Domain\Model\User();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('user', $user);

		$this->subject->showAction($user);
	}
}
