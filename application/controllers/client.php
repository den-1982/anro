<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Client extends CI_Controller 
{
	public $_lang = array(
				'ru' => 'russian',
				'en' => 'english',
				'ua' => 'ukrainian'
			);
			
	public $data = array(
		'act'		=> '',
		'h1'		=> '',
		'name'		=> '',
		'title'		=> '',
		'metadesc'	=> '',
		'metakey'	=> '',
		'text'		=> '',
		'lang' 		=> 'ua'
	);
///////////////////////////////////////////////////////// CONSTRUCT
	public function __construct()
	{
		parent::__construct();

		$this->load->helpers('functions');
		
		$this->load->model(array(
			'client/settingsModel',
			'client/clientModel',
			'client/pageModel',
			'client/materialsModel',
			'client/bannerModel'
		));
		
		# Получить настройки
		$this->data['settings'] = $this->settingsModel->getSettings();

		# Язык
		if ( isset($this->_lang[$this->uri->segment(1)]) ){
			$this->lang->load('site', $this->_lang[$this->uri->segment(1)]);
		}else{
			$this->lang->load('site', 'ukrainian');
		}
	}
///////////////////////////////////////////////////////// __INFO
	private function _info($obj = null, $default = '')
	{
		if ( ! $obj) $obj = new stdClass();

		$this->data['h1']		= isset($obj->h1) ? $obj->h1 : $default;
		$this->data['name']		= isset($obj->name) ? $obj->name : $default;
		$this->data['title']	= isset($obj->title) ? $obj->title : $default;
		$this->data['metadesc']	= isset($obj->metadesc) ? $obj->metadesc : $default;
		$this->data['metakey']	= isset($obj->metakey) ? $obj->metakey : $default;
		$this->data['text']		= isset($obj->text) ? $obj->text : $default;
	}
///////////////////////////////////////////////////////// __VIEW
	private function _view($type, $data)
	{
		$this->load->view('client/'.$type.'.php', $data);
	}
///////////////////////////////////////////////////////// INDEX
	public function Index($lang = 'ua')
	{
		$data = &$this->data;
		
		$data['lang'] = $lang;

		if (isset($_POST['callback'])){
			echo json_encode(
				$this->clientModel->callback()
			);
			exit;
		}
		
		$data['banners'] = $this->bannerModel->getBanners($lang);
		$data['info'] = $this->pageModel->getPageSystem('info', $lang);
		$data['about'] = $this->pageModel->getPageSystem('about', $lang);
		$data['technologies'] = $this->pageModel->getPageSystem('technologies', $lang);
		$data['experience'] = $this->pageModel->getPageSystem('experience', $lang);
		$data['production'] = $this->pageModel->getPageSystem('production', $lang);
		$data['services'] = $this->pageModel->getPageSystem('services', $lang);
		$data['reviews'] = $this->pageModel->getPageSystem('reviews', $lang);
		$data['materials'] = $this->materialsModel->getMaterials($lang);
		
		$this->_info($data['about']->description);

		$this->_view('home', $data);
	}
///////////////////////////////////////////////////////// 404	
	public function _404()
	{
		$data = &$this->data;

		header("HTTP/1.0 404 Not Found");
		

		$this->_info(null, '404');
		
		$this->_view('404', $data);
	}
}