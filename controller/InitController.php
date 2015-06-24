<?php

	class InitController extends Controller{

		public $defaultAction = 'show';

		public function showAction(){
			$this->render('main.content');
		}
	}