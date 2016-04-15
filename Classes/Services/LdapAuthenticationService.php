<?php
/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 14.04.2016
 * Time: 15:23
 */

namespace BenediktRinglein\Wolregistration\Services;

require_once PATH_typo3conf . '/ext/wolregistration/vendor/autoload.php';

use Adldap\Adldap;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Sv\AuthenticationService;

class LdapAuthenticationService extends AuthenticationService
{

	/**
	 * @var Adldap
	 */
	protected $adldap;

	/**
	 * LdapAuthenticationService constructor.
	 * @param Adldap $adldap
	 */
	public function __construct(Adldap $adldap = NULL)
	{
		if ($adldap === NULL) {
			$this->adldap = GeneralUtility::makeInstance("Adldap\\Adldap");
		} else {
			$this->adldap = $adldap;
		}
	}

	/**
	 * Authenticates the user using LDAP
	 *
	 * @param array $userData
	 * @return int 200, if the logindata is valid, otherwise -1
	 */
	public function authUser(array $userData)
	{
		$username = $this->login['uname'];
		$password = $this->login['uident'];
		if ($this->adldap->authenticate($username, $password)) {
			// credentials valid
			return 200;
		} else {
			// credentials invalid
			return -1;
		}
	}
}