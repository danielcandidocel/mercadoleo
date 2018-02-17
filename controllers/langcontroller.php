<?php
class langcontroller extends controller {

	private $user;

    public function __construct() {
        parent::__construct();
    }

    public function index() {}

    public function set($lang) {
    	$_SESSION['lang'] = $lang;
    	header("Location: ".BASE_URL);
    }

}

