<?php
class controller {

	protected $db;
        protected $lang;
        
        public function __construct() {
		global $config;
                $this->lang = new language();
	}
	
	public function loadView($viewName, $viewData = array()) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}

	public function loadTemplate($viewName, $viewData = array()) {
		include 'views/template.php';
	}

	public function loadViewInTemplate($viewName, $viewData) {
		extract($viewData);
		include 'views/'.$viewName.'.php';
	}
        
        public function loadViewCliente($viewName, $viewData = array()) {
		extract($viewData);
		include 'views-cliente/'.$viewName.'.php';
	}

        public function loadTemplateCliente($viewName, $viewData = array()) {
		include 'views-cliente/templateCliente.php';
	}

	public function loadViewInTemplateCliente($viewName, $viewData) {
		extract($viewData);
		include 'views-cliente/'.$viewName.'.php';
	}
}