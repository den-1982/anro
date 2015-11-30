<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	public $data = array(
		'parent' => 0,
		'crumbs' => array()
	);
	
	public function __construct()
	{
		parent::__construct();

		$this->load->helpers('functions');
		
		$this->load->model(
			array(
				'admin/settingsModel',
				'admin/filesModel',
				'admin/adminModel', 
				'admin/pageModel',
				'admin/materialsModel',
				'admin/bannerModel'
			)
		);
		
		# =============================== VALID ADMIN
		$this->adminModel->VALID_ADMIN();
		# ============================END VALID ADMIN
		
		$this->data['settings'] = $this->settingsModel->getSettings();
	}
/////////////////////////////////////////////////////////////////////////////// VIEW
	private function _view($view, $data)
	{
		$this->load->view('admin/parts/a_header.php', $data);
		$this->load->view('admin/'.$view.'.php');
		$this->load->view('admin/parts/a_footer.php');
	}
/////////////////////////////////////////////////////////////////////////////// CRUMBS	
	private function _crumbs($data = array(), $parent = 0)
	{
		static $j = 0;
		
		$crumbs = array();
		do{
			$terac = false;
			foreach ($data as  $item){
				foreach ($item as $i){
					if ($i->id == $parent){
						$crumbs[] = array('id'=>$i->id, 'name'=>$i->name);
						$parent = $i->parent;
						$terac = true;
						break;
					}
				}	
			}
			
			# предохранитель (избегаем зацыкливания)
			$j++;
			if ($j > 100000)return;
			# =====================================
			
		}while ($terac);

		return array_reverse($crumbs);
	}
/////////////////////////////////////////////////////////////////////////////// URL
	private function _getParents($parents, $not = 0, $parent_id = 0, $parent_name = '', $level = -1) 
	{
		$output = array();
		$level++;
		
		if (array_key_exists($parent_id, $parents)) {
			if ($parent_name != '') {
				$parent_name .= ' > ';
			}

			foreach ($parents[$parent_id] as $parent) {
				# избегаем зацыкливания
				if ($parent->id == $not) continue;
				
				$output[$parent->id] = array(
					'id' => $parent->id,
					'name' => $parent_name . $parent->name,
					'_name'=>$parent->name,
					'level'=>$level
				);
				
				$output += $this->_getParents($parents, $not, $parent->id, $parent_name . $parent->name, $level);
			}
		}
		return $output;
	}
/////////////////////////////////////////////////////////////////////////////// INDEX
	public function Index()
	{
		$data = &$this->data;
		
		$data['path']	= '/admin/';
		$data['action']	= 'index';
		$data['act']	= 'all';
		$data['h1']		= 'Админ';
		
		$data = $this->data;
		$this->_view('a_index', $data);
	}
/////////////////////////////////////////////////////////////////////////////// INFO
	public function Info()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/info/';
		$data['action']   	= 'info';
		$data['act']      	= 'all';
		$data['h1']     	= 'Инфо';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['info'] = $this->pageModel->getPageSystem('info');
		
		$this->_view('a_info', $data);
	}
/////////////////////////////////////////////////////////////////////////////// ABOUT
	public function About()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/about/';
		$data['action']   	= 'about';
		$data['act']      	= 'all';
		$data['h1']     	= 'О нас';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['about'] = $this->pageModel->getPageSystem('about');
		
		$this->_view('a_about', $data);
	}
/////////////////////////////////////////////////////////////////////////////// TECHNOLOGIES
	public function Technologies()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/technologies/';
		$data['action']   	= 'technologies';
		$data['act']      	= 'all';
		$data['h1']     	= 'Технологии';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['technologies'] = $this->pageModel->getPageSystem('technologies');
		
		$this->_view('a_technologies', $data);
	}
/////////////////////////////////////////////////////////////////////////////// EXPERIENCE
	public function Experience()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/experience/';
		$data['action']   	= 'experience';
		$data['act']      	= 'all';
		$data['h1']     	= 'Опыт';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['experience'] = $this->pageModel->getPageSystem('experience');
		
		$this->_view('a_experience', $data);
	}
/////////////////////////////////////////////////////////////////////////////// SERVICES
	public function Services()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/services/';
		$data['action']   	= 'services';
		$data['act']      	= 'all';
		$data['h1']     	= 'Услуги';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['services'] = $this->pageModel->getPageSystem('services');
		
		$this->_view('a_services', $data);
	}
/////////////////////////////////////////////////////////////////////////////// PRODUCTION
	public function Production()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/production/';
		$data['action']   	= 'production';
		$data['act']      	= 'all';
		$data['h1']     	= 'Производство';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['production'] = $this->pageModel->getPageSystem('production');
		
		$this->_view('a_production', $data);
	}
/////////////////////////////////////////////////////////////////////////////// REVIEWS
	public function Reviews()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/reviews/';
		$data['action']   	= 'reviews';
		$data['act']      	= 'all';
		$data['h1']     	= 'Отзывы';

		if (isset($_POST['edit'])){
			$this->pageModel->updatePageSystem();
			exit;
		}
		
		$data['reviews'] = $this->pageModel->getPageSystem('reviews');
		
		$this->_view('a_reviews', $data);
	}
///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////// MATERIALS
	public function Materials()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/materials/';
		$data['action']   	= 'materials';
		$data['act']      	= 'all';
		$data['h1']     	= 'Материалы';
		
		if (isset($_GET['delete'])){
			$this->materialsModel->delMaterial($_GET['delete']);
			redirect($data['path']);
			exit;
		}
		
		if (isset($_POST['add'])){
			$this->materialsModel->addMaterial();
			redirect($data['path']);
			exit;
		}
		if (isset($_POST['edit'])){
			$this->materialsModel->editMaterial();
			redirect($data['path']);
			exit;
		}
		if(isset($_POST['materials_order'])){
			$this->materialsModel->setOrderMaterials();
			exit;
		}
		if ( isset($_POST['toggle']) ){
			switch($_POST['toggle']){
				case 'visibility':
					echo json_encode($this->materialsModel->setVisibilityMaterial()); 
					exit;
				default:exit;
			}
		}
		
		
		if (isset($_GET['add'])){
			$data['act'] = 'add';
			$data['h1']  = 'Добавить группу материалов';
			$this->_view('a_materials', $data);
			return;
		}
		if (isset($_GET['edit'])){
			$data['material'] = $this->materialsModel->getMaterial($_GET['edit']);
			if ( ! $data['material']) {
				redirect($data['path'].'?parent='.$data['parent']);
				exit;
			}
			$data['act'] = 'edit';
			$data['h1']  = 'Редактирование материала';
			$this->_view('a_materials', $data);
			return;
		}
		
		$data['materials'] = $this->materialsModel->getMaterials();
		
		$this->_view('a_materials', $data);
	}
/////////////////////////////////////////////////////////////////////////////// BANNER
	public function Banner()
	{
		$data = &$this->data;
		
		$data['path']		= '/admin/banner/';
		$data['action']   	= 'banner';
		$data['act']      	= 'all';
		$data['h1']     	= 'Банер';
		
		if (isset($_POST['edit'])){
			$this->bannerModel->editBanner();
			redirect($data['path']);
			exit;
		}
		
		$data['banners'] = $this->bannerModel->getBanner();

		$this->_view('a_banner', $data);
	}
/////////////////////////////////////////////////////////////////////////////// SETTINGS
	public function Settings()
	{
		$data = &$this->data;

		$data['path']		= '/admin/settings/';
		$data['action']   	= 'settings';
		$data['act']      	= 'all';
		$data['h1']     	= 'Настройки';
		
		# обновление данных
		if (isset($_POST['edit'])){
			$this->settingsModel->editSettings();
			redirect($data['path']);
			exit;
		}
		
		$data['settings'] = $this->settingsModel->getSettings();
		$data['admin'] = $this->adminModel->getAdmin();
		$data['language'] = $this->settingsModel->getLanguage();
		$data['social'] = $this->settingsModel->getSocial();
		
		$this->output->set_header("Cache-Control: no-store");
		$this->_view('a_settings', $data);
		return;
	}
/////////////////////////////////////////////////////////////////////////////// FILE_MANAGER
	public function FilesManager()
	{
		if ( ! isset($_POST['action'])){
			$this->_404();
			return;
		}

		if ( ! in_array($_POST['action'], get_class_methods($this->filesModel))){
			log_message('errror', 'Нет такого метода. '.__DIR__ .' :: '.__LINE__);
			$this->_404();
			return;
		}
		
		echo json_encode($this->filesModel->$_POST['action']());
		exit;
	}
/////////////////////////////////////////////////////////////////////////////// _404
	public function _404()
	{	
		header("HTTP/1.0 404 Not Found");
		exit;
	}
	
}