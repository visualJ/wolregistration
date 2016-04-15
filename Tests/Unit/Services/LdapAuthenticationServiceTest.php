<?php

/**
 * Created by PhpStorm.
 * User: benedikt.ringlein
 * Date: 14.04.2016
 * Time: 15:36
 */

use \BenediktRinglein\Wolregistration\Services\LdapAuthenticationService;

class LdapAuthenticationServiceTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \BenediktRinglein\Wolregistration\Services\LdapAuthenticationService
	 */
	protected $ldapAuthenticationService;

	protected $adldap;

	public function setUp()
	{
		$this->adldap = $this->getMockBuilder("Adldap\\Adldap")->getMock();
		$this->ldapAuthenticationService = new LdapAuthenticationService($this->adldap);
	}

	/**
	 * Tests, if the ldap authentication service returns the correct value for a valid user.
	 * The expected return value of authUser is >= 200
	 *
	 * @test
	 */
	public function canAuthenticateValidUser()
	{
		$this->adldap->method('authenticate')->willReturn(true);
		$this->adldap->expects($this->once())->method('authenticate');

		$resultCode = $this->ldapAuthenticationService->authUser(array());
		$this->assertGreaterThanOrEqual(200, $resultCode);
	}

	/**
	 * Tests, if the ldap authentication service returns the correct value for an invalid user
	 * The expected return value of authUser is <= 0
	 *
	 * @test
	 */
	public function cantAuthenticateInvalidUser()
	{
		$this->adldap->method('authenticate')->willReturn(false);
		$this->adldap->expects($this->once())->method('authenticate');

		$resultCode = $this->ldapAuthenticationService->authUser(array());
		$this->assertLessThanOrEqual(0, $resultCode);
	}
}
