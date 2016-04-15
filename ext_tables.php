<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'BenediktRinglein.' . $_EXTKEY,
	'Wolview',
	'WoL View'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'WoL Registration');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wolregistration_domain_model_user', 'EXT:wolregistration/Resources/Private/Language/locallang_csh_tx_wolregistration_domain_model_user.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wolregistration_domain_model_user');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_wolregistration_domain_model_device', 'EXT:wolregistration/Resources/Private/Language/locallang_csh_tx_wolregistration_domain_model_device.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_wolregistration_domain_model_device');
