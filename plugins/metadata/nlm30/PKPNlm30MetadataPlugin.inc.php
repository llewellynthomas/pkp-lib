<?php
/**
 * @defgroup plugins_metadata_nlm30 NLM 3.0 Metadata Plugin
 */

/**
 * @file plugins/metadata/nlm30/PKPNlm30MetadataPlugin.inc.php
 *
 * Copyright (c) 2003-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPNlm30MetadataPlugin
 * @ingroup plugins_metadata_nlm30
 *
 * @brief Abstract base class for NLM 3.0 metadata plugins
 */


import('lib.pkp.classes.plugins.MetadataPlugin');

class PKPNlm30MetadataPlugin extends MetadataPlugin {
	/**
	 * Constructor
	 */
	function PKPNlm30MetadataPlugin() {
		parent::MetadataPlugin();
	}


	//
	// Override protected template methods from PKPPlugin
	//
	/**
	 * @copydoc PKPPlugin::getName()
	 */
	function getName() {
		return 'Nlm30MetadataPlugin';
	}

	/**
	 * @copydoc PKPPlugin::getDisplayName()
	 */
	function getDisplayName() {
		return __('plugins.metadata.nlm30.displayName');
	}

	/**
	 * @copydoc PKPPlugin::getDescription()
	 */
	function getDescription() {
		return __('plugins.metadata.nlm30.description');
	}
}

?>
