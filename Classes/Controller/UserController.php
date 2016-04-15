<?php
namespace BenediktRinglein\Wolregistration\Controller;

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
use BenediktRinglein\Wolregistration\Domain\Model\Device;
use TYPO3\CMS\Extbase\Domain\Model\FrontendUser;

/**
 * UserController
 */
class UserController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

	/**
	 * userRepository
	 *
	 * @var \BenediktRinglein\Wolregistration\Domain\Repository\UserRepository
	 * @inject
	 */
	protected $userRepository = NULL;

	/**
	 * macAddressService
	 *
	 * @var \BenediktRinglein\Wolregistration\Services\MacAddressService
	 * @inject
	 */
	protected $macAddressService = NULL;

	/**
	 * @var FrontendUser
	 */
	protected $fe_user;

	public function __construct(FrontendUser $fe_user = NULL)
	{
		if($fe_user === NULL){
			$this->fe_user = $GLOBALS['TSFE']->fe_user;
		}else{
			$this->fe_user = $fe_user;
		}
	}

	/**
	 * action show
	 * Shows the details page of a user
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\User $user
	 * @return void
	 */
	public
	function showAction(\BenediktRinglein\Wolregistration\Domain\Model\User $user)
	{
		$this->view->assign('user', $user);
		$this->fe_user->setKey("ses", "user", $user->getLoginName());
	}

	/**
	 * action addDevice
	 * Adds a device to the user.
	 * The show action must have been called before.
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\Device|NULL $newDevice
	 */
	public
	function addDeviceAction(\BenediktRinglein\Wolregistration\Domain\Model\Device $newDevice = NULL)
	{
		if ($newDevice != NULL) {
			// user submitted a device, persist it
			$userLoginName = $this->fe_user->getKey("ses", "user");
			$user = $this->userRepository->findOneByLoginName($userLoginName);
			if (!$user->hasDeviceWithMacAddress($newDevice->getMacAddress())) {
				$user->addDevice($newDevice);
				$this->userRepository->update($user);
			} else {
				$this->addFlashMessage('A device with this MAC address was already added!', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
			}
			$this->redirect('show', NULL, NULL, array('user' => $user));
		} else {
			// User did not submit a device in this form, get his mac address
			$macAddress = $this->macAddressService->getClientMacAddress();
			if ($macAddress) {
				$newDevice = new Device();
				$newDevice->setMacAddress($macAddress);
				$this->view->assign('newDevice', $newDevice);
			}
		}
	}

	/**
	 * action removeDevice
	 * Removes a device from the user.
	 * The show action must have been called before.
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\Device $device
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
	 * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
	 */
	public
	function removeDeviceAction(\BenediktRinglein\Wolregistration\Domain\Model\Device $device)
	{
		$userLoginName = $this->fe_user->getKey("ses", "user");
		$user = $this->userRepository->findOneByLoginName($userLoginName);
		$user->removeDevice($device);
		$this->userRepository->update($user);
		$this->redirect('show', NULL, NULL, array('user' => $user));
	}

	/**
	 * action login
	 * Logs in a user. If the user ist new, a new user object is created.
	 *
	 * @param \BenediktRinglein\Wolregistration\Domain\Model\User|NULL $user
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
	 * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
	 */
	public
	function loginAction(\BenediktRinglein\Wolregistration\Domain\Model\User $user = NULL)
	{
		if ($user != NULL) {
			if ($this->userRepository->countByLoginName($user->getLoginName()) <= 0) {
				// add user, if not known already
				$this->userRepository->add($user);
				$persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
				$persistenceManager->persistAll();
			}
			$this->redirect('show', NULL, NULL, array('user' => $this->userRepository->findOneByLoginName($user->getLoginName())));
		}
	}

	/**
	 * action logout
	 * logs the user out and redirects to the login page.
	 *
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException
	 */
	public
	function logoutAction()
	{
		$this->fe_user->setKey("ses", "user", '');
		$this->redirect('login');
	}

}