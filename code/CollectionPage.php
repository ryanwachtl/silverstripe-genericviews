<?php
/**
 * @package genericviews
 * @author Sam Minnée, SilverStripe Ltd. (<firstname>@silverstripe.com)
 */
class CollectionPage extends Page {

	static $db = array(
		'CollectionModelClass' => 'Varchar(255)',
		'CollectionControllerClass' => 'Varchar(255)'
	);
	
	static $defaults = array(
		'CollectionControllerClass' => 'CollectionController'
	);
	
	public function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$modelClasses = ClassInfo::subclassesFor('DataObject');
		$modelClassesMap = array_combine($modelClasses,$modelClasses);
		asort($modelClassesMap);
		$fields->addFieldToTab('Root.Content.Main',
			new DropdownField('CollectionModelClass', null, $modelClassesMap)
		);
		
		$controllerClasses = ClassInfo::subclassesFor('CollectionController');
		$controllerClassesMap = array_combine($controllerClasses,$controllerClasses);
		asort($controllerClassesMap);
		$fields->addFieldToTab('Root.Content.Main',
			new DropdownField('CollectionControllerClass', null, $controllerClassesMap)
		);
		
		return $fields;
	}
}
class CollectionPage_Controller extends Page_Controller {
	
	static $url_handlers = array(
		'' => 'handleCollection',
	);
	
	function init() {
		$this->set_stat('url_handlers', array(
			$this->dataRecord->CollectionModelClass => 'handleCollection'
		));
		
		parent::init();
	}
	
	function handleCollection($request) {
		$modelClass = $this->dataRecord->CollectionModelClass;
		if(!$modelClass || !(singleton($modelClass) instanceof DataObject)) {
			user_error("CollectionPage_Controller: Invalid model class '$modelClass'", E_USER_ERROR);
		}
		$controllerClass = $this->dataRecord->CollectionControllerClass;
		if(!$controllerClass || !(singleton($controllerClass) instanceof CollectionController)) {
			user_error("CollectionPage_Controller: Invalid controller class '$controllerClass'", E_USER_ERROR);
		}
		
		return new $controllerClass($this, $modelClass);
	}
}
?>