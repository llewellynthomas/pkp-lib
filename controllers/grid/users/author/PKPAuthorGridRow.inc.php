<?php

/**
 * @file controllers/grid/users/author/PKPAuthorGridRow.inc.php
 *
 * Copyright (c) 2000-2013 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class PKPAuthorGridRow
 * @ingroup controllers_grid_users_author
 *
 * @brief Base class for author grid row definition
 */

import('lib.pkp.classes.controllers.grid.GridRow');

class PKPAuthorGridRow extends GridRow {
	/** @var Submission **/
	var $_submission;

	/** @var boolean */
	var $_reaadOnly;

	/**
	 * Constructor
	 */
	function PKPAuthorGridRow($submission, $readOnly = false) {
		$this->_submission = $submission;
		$this->_readOnly = $readOnly;
		parent::GridRow();
	}

	//
	// Overridden methods from GridRow
	//
	/**
	 * @see GridRow::initialize()
	 * @param $request PKPRequest
	 */
	function initialize($request) {
		// Do the default initialization
		parent::initialize($request);

		// Retrieve the submission from the request
		$submission = $this->getSubmission();

		// Is this a new row or an existing row?
		$rowId = $this->getId();
		if (!empty($rowId) && is_numeric($rowId)) {
			// Only add row actions if this is an existing row
			$router = $request->getRouter();
			$actionArgs = $this->getRequestArgs();
			$actionArgs['authorId'] = $rowId;

			// Add row-level actions
			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$this->addAction(
				new LinkAction(
					'editAuthor',
					new AjaxModal(
						$router->url($request, null, null, 'editAuthor', null, $actionArgs),
						__('grid.action.editContributor'),
						'modal_edit'
					),
					__('grid.action.edit'),
					'edit'
				)
			);

			import('lib.pkp.classes.linkAction.request.RemoteActionConfirmationModal');
			$this->addAction(
				new LinkAction(
					'deleteAuthor',
					new RemoteActionConfirmationModal(
						__('common.confirmDelete'),
						__('common.delete'),
						$router->url($request, null, null, 'deleteAuthor', null, $actionArgs),
						'modal_delete'
					),
					__('grid.action.delete'),
					'delete'
				)
			);

			if ($this->allowedToCreateUser($request)) {
				$authorDao = DAORegistry::getDAO('AuthorDAO');
				$userDao = DAORegistry::getDAO('UserDAO');
				$author =& $authorDao->getAuthor($rowId);

				if ($author && !$userDao->userExistsByEmail($author->getEmail())) {
					$this->addAction(
						new LinkAction(
							'addUser',
							new AjaxModal(
								$router->url($request, null, null, 'addUser', null, $actionArgs),
								__('grid.user.add'),
								'modal_add_user',
								true
								),
							__('grid.user.add'),
							'add_user')
					);
				}
			}
		}
	}

	/**
	 * Get the submission for this row (already authorized)
	 * @return Submission
	 */
	function &getSubmission() {
		return $this->_submission;
	}

	/**
	 * Get the base arguments that will identify the data in the grid.
	 * @return array
	 */
	function getRequestArgs() {
		$submission = $this->getSubmission();
		return array(
			'submissionId' => $submission->getId()
		);
	}

	/**
	 * Determines whether the current user can create user accounts from authors present
	 * in the grid.
	 * Overridden by child grid rows.
	 * @param PKPRequest $request
	 * @return boolean
	 */
	function allowedToCreateUser($request) {
		return false;
	}

	/**
	 * Determine if this grid row should be read only.
	 * @return boolean
	 */
	function isReadOnly() {
		return $this->_readOnly;
	}
}

?>
