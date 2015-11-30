<?php
// CLIENT
class settingsModel extends CI_Model
{
	public function getSettings()
	{
		$settings = $this->db->query('SELECT * FROM settings')->row();
		$settings->phone = unserialize($settings->phone);
		$settings->social = unserialize($settings->social);
		$settings->language = $this->getLanguage();
	
		return $settings;
	}
	
	public function getLanguage(){
		$res = $this->db->query('SELECT * FROM language WHERE visibility = 1 ORDER BY `order` ASC')->result();
		
		$lang = array();
		foreach ($res as $l){
			$lang[$l->code] = $l;
		}
		return $lang;
	}
	
}