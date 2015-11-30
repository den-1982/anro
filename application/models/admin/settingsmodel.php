<?php
/*	
*	fashiondance.in.ua
*/
class settingsModel extends CI_Model
{
	static private $settingsData;
	
	public function getSettings()
	{
		if (self::$settingsData) return self::$settingsData;
		
		$settings = $this->db->query('SELECT * FROM settings')->row();
		$settings->phone = unserialize($settings->phone);
		$settings->sizes = unserialize($settings->sizes);
		$settings->social = unserialize($settings->social);
		$settings->language = $this->getLanguage();
		
		self::$settingsData = $settings;
		
		return $settings;
	}
	
	public function editSettings()
	{
		$data['manager']	= isset($_POST['manager']) ? clean($_POST['manager'], true, true) : '';
		$data['skype']		= isset($_POST['skype']) ? clean($_POST['skype'], true, true) : '';
		$data['email']		= isset($_POST['email']) ? clean($_POST['email'], true, true) : '';
		
		$data['analitics']	= isset($_POST['analitics']) ? clean($_POST['analitics'], false, true) : '';
		$data['metrica']	= isset($_POST['metrica']) ? clean($_POST['metrica'], false, true) : '';
		$data['map']		= isset($_POST['map']) ? clean($_POST['map'], false, true) : '';
		$data['coordinates']= isset($_POST['coordinates']) ? clean($_POST['coordinates'], false, true) : '';
		
		# PHONE
		$phones	= isset($_POST['phone']) && is_array($_POST['phone']) ? $_POST['phone'] : array();
		$data['phone'] = array();
		foreach ($phones as &$phone){
			if ($phone = trim(preg_replace('/[^0-9\-\+\(\)\s]/iu', '', $phone)))
				$data['phone'][] = preg_replace('/\s+/', ' ', $phone);
		}
		$data['phone'] = clean(serialize($data['phone']), false, true);
		
		# FAX
		$data['fax'] = isset($_POST['fax']) ? $_POST['fax'] : '';
		$data['fax'] = trim(preg_replace('/[^0-9\-\+\(\)\s]/iu', '', $data['fax']));
		$data['fax'] = preg_replace('/\s+/', ' ', $data['fax']);
		
		# SOCIAL
		$data['social'] = array();
		if (isset($_POST['social_name'])){
			for ($i = 0, $cnt = count($_POST['social_name']); $i < $cnt; $i++){

				$name = isset($_POST['social_name'][$i]) ? trim($_POST['social_name'][$i]) : '';
				$link = isset($_POST['social_link'][$i]) ? trim($_POST['social_link'][$i]) : '';
				
				if (!$name || !$link) continue;
				
				$data['social'][$name] = $link;
			}
		}
		$data['social'] = clean(serialize($data['social']), false, true);
		
		# Адресс
		$data['country'] = isset($_POST['country']) ? clean($_POST['country'], true, true) : '';
		$data['city'] = isset($_POST['city']) ? clean($_POST['city'], true, true) : '';
		$data['address'] = isset($_POST['address']) ? clean($_POST['address'], true, true) : '';
		$data['postal_code'] = isset($_POST['postal_code']) ? clean($_POST['postal_code'], true, true) : '';
		
		$this->db->query('UPDATE settings 
							SET 
								manager = "'.$data['manager'].'",
								skype = "'.$data['skype'].'",
								email = "'.$data['email'].'",
								phone = "'.$data['phone'].'",
								fax = "'.$data['fax'].'",
								social = "'.$data['social'].'",
								country = "'.$data['country'].'",
								city = "'.$data['city'].'",
								address = "'.$data['address'].'",
								postal_code = "'.$data['postal_code'].'",
								analitics = "'.$data['analitics'].'",
								metrica = "'.$data['metrica'].'",
								map = "'.$data['map'].'",
								coordinates = "'.$data['coordinates'].'"
							');
										
		# ADMIN
		if (isset($_POST['admin']['login'])){
			$data['login'] = clean($_POST['admin']['login'], false, true);
			$this->db->query('UPDATE admin SET login = "'.$data['login'].'" ');
		}
		if (isset($_POST['admin']['password'])){
			$data['password'] = mysql_real_escape_string($_POST['admin']['password']);
			$this->db->query('UPDATE admin SET password = "'.$data['password'].'" ');
		}
		if (isset($_POST['admin']['email'])){
			$data['email'] = clean($_POST['admin']['email'], true, true);
			$this->db->query('UPDATE admin SET email = "'.$data['email'].'" ');
		}

		
		# SIZEZ filesModel
		$sizes = array();
		$this->db->query('UPDATE settings SET sizes = "'. serialize($sizes) .'"');
		if (isset($_POST['image_size'])){
			foreach ($_POST['image_size'] as $size){
				$size = abs((int)$size);
				if ( $size ) $sizes[] = $size;
			}
			
			$this->db->query('UPDATE settings SET sizes = "'. serialize($sizes) .'"');
		}
		
		return;
	}
	
	public function getLanguage(){
		return $this->db->query('SELECT * FROM language WHERE visibility = 1 ORDER BY `order` ASC')->result();
	}
	
	public function getSocial(){
		return $this->db->query('SELECT * FROM social')->result();
	}
	
}