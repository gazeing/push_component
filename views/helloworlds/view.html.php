<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * HelloWorlds View
 */
class HelloWorldViewHelloWorlds extends JViewLegacy
{
	
	protected $form;
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Get data from the model
		$items      = $this->get('Items');
		$pagination = $this->get('Pagination');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
		// Assign data to the view
		$this->items      = $items;
		$this->pagination = $pagination;

// 		include 'C:\Suresh\REBProject\PHP_WorkSpace\old\SPI\administrator\components\com_helloworld\views\helloworlds\push\simplepush.php';
// 		pushOneId('');
		
		$this->addToolBar();
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS'));
	// 		JToolBarHelper::deleteList('', 'helloworlds.delete');
	// 		JToolBarHelper::editList('helloworld.edit');
	// 		JToolBarHelper::addNew('helloworld.add');
		JToolbarHelper::publish('helloworld.publish');
		JToolbarHelper::divider();
		JToolBarHelper::cancel('helloworld.cancel',  'JTOOLBAR_CLOSE');
	}
}