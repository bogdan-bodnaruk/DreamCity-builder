<?php
class Controller_login extends DRM {
	public function index() {
		$this->template()->load('login.tpl')->show();
	}
	public function forgotpass() {
		if($_POST && $this->template()->post_is_valide()) {
			$this->template()->load('All good!')->show();
		} else { 
			$this->template()->load('forgotpass.tpl')->show();
		};
	}
}
