<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Thomas Maroschik <tmaroschik@dfau.de>
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
 *  A copy is found in the textfile GPL.txt and important notices to the license
 *  from the author is found in LICENSE.txt distributed with these scripts.
 *
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

// Configure the default identity providers.
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF'][$_EXTKEY] = array(
	Tx_Identity_Configuration_IdentityProviderInterface::PROVIDERS_LIST	=> array(
		'recordUuid'	=> array(
			Tx_Identity_Configuration_IdentityProviderInterface::IDENTITY_FIELD					=>	'uuid',
			Tx_Identity_Configuration_IdentityProviderInterface::IDENTITY_FIELD_CREATE_CLAUSE	=>	'char(36) NOT NULL default \'\'',
			Tx_Identity_Configuration_IdentityProviderInterface::PROVIDER_CLASS					=>	'Tx_Identity_Provider_RecordUuid',
		),
		'staticRecordUuid'	=> array(
			Tx_Identity_Configuration_IdentityProviderInterface::IDENTITY_FIELD					=>	'uuid',
			Tx_Identity_Configuration_IdentityProviderInterface::IDENTITY_FIELD_CREATE_CLAUSE	=>	'char(36) NOT NULL default \'\'',
			Tx_Identity_Configuration_IdentityProviderInterface::PROVIDER_CLASS					=>	'Tx_Identity_Provider_StaticRecordUuid',
		),
	),
	Tx_Identity_Configuration_IdentityProviderInterface::DEFAULT_PROVIDER	=> 'recordUuid',
);

// Register a hook for tce main
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/class.tx_identity_tcemain_hook.php:tx_identity_tcemain_hook';

//Register a hook for DB
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_db.php']['queryProcessors'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/Classes/Hooks/class.tx_identity_t3lib_db_preprocess.php:tx_identity_t3lib_db_preprocess';

// Register a hook for the extension manager
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/mod/tools/em/index.php']['checkDBupdates'][] = 'EXT:identity/Classes/Hooks/class.tx_identity_em_hook.php:tx_identity_em_hook';

// Register a hook for the install tool
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install/mod/class.tx_install.php']['checkTheDatabase'][] = 'EXT:identity/Classes/Hooks/class.tx_identity_em_hook.php:tx_identity_em_hook';


	// Register extension list update task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_Identity_Tasks_RebuildTask'] = array(
	'extension'			=> $_EXTKEY,
	'title'				=> 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:tasks_rebuildTask.name',
	'description'		=> 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xml:tasks_rebuildTask.description',
	'additionalFields'	=> '',
);

?>