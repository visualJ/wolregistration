<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'BenediktRinglein.' . $_EXTKEY,
	'Wolview',
	array(
		'User' => 'login, logout, addDevice, removeDevice, show',
	),
	// non-cacheable actions
	array(
		'User' => 'addDevice, removeDevice, login, logout',
	)
);

// Register LDAP user authentication service:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addService($_EXTKEY, 'auth', 'BenediktRinglein\\Wolregistration\\Services\\LdapAuthenticationService', array(
	'title' => 'LDAP authentication service',
	'description' => 'LDAP frontend user authentication service',
	// Methods that can be handled by this service:
	'subtype' => 'getUserFE,authUserFE,getGroupsFE',
	'available' => true,
	// OpenID has priority:75 and quality:50, thus we need a bit more:
	'priority' => 75, 'quality' => 55,
	// Internal definitions:
	'os' => '',
	'exec' => '',
	'className' => 'BenediktRinglein\\Wolregistration\\Services\\LdapAuthenticationService',
));
