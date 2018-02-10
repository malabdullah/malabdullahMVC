<?php

namespace App\Core;

class Controller {

	public function model($model){
		
		if (file_exists(APPPATH . '/models/' . $model . '.php')){
			$class = '\\App\\Models\\' . $model;
			return new $class;
		}
	}

	public function view($view, array $data = [], $title = SITENAME){
		if (file_exists(APPPATH . '/views/' . $view . '.php')){

			foreach ($data as $key => $value) {
				$$key = $value;
			}

			require_once APPPATH . '/views/' . $view . '.php';
		}
	}
}