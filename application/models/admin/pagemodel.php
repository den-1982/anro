<?php
/*
*	ADMIN
*/
class pageModel extends CI_Model
{
	public function getPageSystem($type = '')
	{
		$type = clean($type, true, true);
		$page = $this->db->query('SELECT * FROM pages WHERE type = "'.$type.'"')->row();
		
		if ( ! $page) return array();
		
		# DESCRIPTION
		$page->description = array();
		$description = $this->db->query('SELECT pd.*, 
												l.id AS language_id 
											FROM language l
											LEFT JOIN pages_description pd 
												ON l.id = pd.language_id 
												AND pd.pages_id = "'.$page->id.'"')->result();
		foreach ($description as $k){
			$page->description[$k->language_id] = $k;
		}
		
		# IMAGES
		$page->images = $this->db->query('SELECT * FROM pages_images WHERE pages_id = "'.$page->id.'" ORDER BY `order` ASC')->result();
		foreach ($page->images as $k){
			
			$k->cache = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->image);
			
			$description = $this->db->query('SELECT pid.*, 
													l.id AS language_id 
												FROM language l
												LEFT JOIN pages_images_description pid 
													ON l.id = pid.language_id 
													AND pid.pages_images_id = "'.$k->id.'"')->result();
			foreach ($description as $j){
				$k->description[$j->language_id] = $j;
			}
		}

		return $page;
	}
	
	public function updatePageSystem()
	{
		# ID PAGE
		$id		= isset($_POST['id'])		? abs((int)$_POST['id']) : 0;
		$image	= isset($_POST['image'])	? clean($_POST['image'], false, true) : '';
		
		$this->db->query('UPDATE pages SET image = "'.$image.'" WHERE id = "'.$id.'"');
		
		# DESCRIPTION
		$insert = array();
		if (isset($_POST['description'])) foreach ($_POST['description'] as $k=>$v){
			$language_id = abs((int)$k);
			
			$h1			= isset($_POST['description'][$k]['h1'])		? clean($_POST['description'][$k]['h1'], true, true) : '';
			$name		= isset($_POST['description'][$k]['name'])		? clean($_POST['description'][$k]['name'], true, true) : '';
			$title		= isset($_POST['description'][$k]['title'])		? clean($_POST['description'][$k]['title'], true, true) : '';
			$metadesc	= isset($_POST['description'][$k]['metadesc'])	? clean($_POST['description'][$k]['metadesc'], true, true) : '';
			$metakey	= isset($_POST['description'][$k]['metakey'])	? clean($_POST['description'][$k]['metakey'], true, true) : '';
			$text		= isset($_POST['description'][$k]['text'])		? clean($_POST['description'][$k]['text'], false, true) : '';
			
			$insert[] = '("'.$id.'", "'.$language_id.'", "'.$name.'", "'.$h1.'", "'.$title.'", "'.$metadesc.'", "'.$metakey.'", "'.$text.'")';
		}
		# очищаем описания
		$this->db->query('DELETE FROM pages_description WHERE pages_id = "'.$id.'"');
		// а что если $insert пустой ??????
		if ($insert){
			$this->db->query('INSERT INTO pages_description (pages_id, language_id, name, h1, title, metadesc, metakey, text) 
							VALUES '. implode($insert, ','));
		}
		

		# IMAGES
		$this->db->query('DELETE FROM pages_images WHERE pages_id = "'.$id.'"');
		if (isset($_POST['images']['update'])) foreach ($_POST['images']['update'] as $k=>$v){
			$id_image = abs((int)$k);
			
			$order	= isset($_POST['images_order']['update'][$k])	? abs((int)$_POST['images_order']['update'][$k]) : 0;
			$img 	= isset($_POST['images']['update'][$k])			? clean($_POST['images']['update'][$k], true, true) : '';
			
			if ( ! $img) continue;
			
			# INSERT IMAGES
			$this->db->query('INSERT INTO pages_images (id, pages_id, image, `order`) 
							VALUES(
								"'.$id_image.'",
								"'.$id.'",
								"'.$img.'",
								"'.$order.'"
							)');
			
			if (isset($_POST['images_description']['update'][$k])) foreach ($_POST['images_description']['update'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['images_description']['update'][$k][$l]['h1'])		? clean($_POST['images_description']['update'][$k][$l]['h1'], true, true) : '';
				$name		= isset($_POST['images_description']['update'][$k][$l]['name'])		? clean($_POST['images_description']['update'][$k][$l]['name'], true, true) : '';
				$title		= isset($_POST['images_description']['update'][$k][$l]['title'])	? clean($_POST['images_description']['update'][$k][$l]['title'], true, true) : '';
				$metadesc	= isset($_POST['images_description']['update'][$k][$l]['metadesc']) ? clean($_POST['images_description']['update'][$k][$l]['metadesc'], true, true) : '';
				$metakey	= isset($_POST['images_description']['update'][$k][$l]['metakey'])	? clean($_POST['images_description']['update'][$k][$l]['metakey'], true, true) : '';
				$text		= isset($_POST['images_description']['update'][$k][$l]['text']) 	? clean($_POST['images_description']['update'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO pages_images_description (pages_images_id, language_id, name, h1, title, metadesc, metakey, text) 
									VALUES(
										"'.$id_image.'",
										"'.$language_id.'",
										"'.$name.'",
										"'.$h1.'",
										"'.$title.'",
										"'.$metadesc.'",
										"'.$metakey.'",
										"'.$text.'"
									)');
				
			}
		}
		if (isset($_POST['images']['insert'])) foreach ($_POST['images']['insert'] as $k=>$v){

			$order	= isset($_POST['images_order']['insert'][$k])	? abs((int)$_POST['images_order']['insert'][$k]) : 0;
			$img 	= isset($_POST['images']['insert'][$k])			? clean($_POST['images']['insert'][$k], true, true) : 0;
			
			if ( ! $img) continue;
			
			# INSERT IMAGES
			$this->db->query('INSERT INTO pages_images (pages_id, image, `order`) 
								VALUES(
									"'.$id.'",
									"'.$img.'",
									"'.$order.'"
								)');
			
			# get id_iamge
			$id_image = $this->db->query('SELECT MAX(id) AS id FROM pages_images')->row()->id;
			
			if (isset($_POST['images_description']['insert'][$k])) foreach ($_POST['images_description']['insert'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['images_description']['insert'][$k][$l]['h1'])		? clean($_POST['images_description']['insert'][$k][$l]['h1'], true, true) : '';
				$name		= isset($_POST['images_description']['insert'][$k][$l]['name'])		? clean($_POST['images_description']['insert'][$k][$l]['name'], true, true) : '';
				$title		= isset($_POST['images_description']['insert'][$k][$l]['title'])	? clean($_POST['images_description']['insert'][$k][$l]['title'], true, true) : '';
				$metadesc	= isset($_POST['images_description']['insert'][$k][$l]['metadesc']) ? clean($_POST['images_description']['insert'][$k][$l]['metadesc'], true, true) : '';
				$metakey	= isset($_POST['images_description']['insert'][$k][$l]['metakey'])	? clean($_POST['images_description']['insert'][$k][$l]['metakey'], true, true) : '';
				$text		= isset($_POST['images_description']['insert'][$k][$l]['text']) 	? clean($_POST['images_description']['insert'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO pages_images_description (pages_images_id, language_id, name, h1, title, metadesc, metakey, text) 
									VALUES(
										"'.$id_image.'",
										"'.$language_id.'",
										"'.$name.'",
										"'.$h1.'",
										"'.$title.'",
										"'.$metadesc.'",
										"'.$metakey.'",
										"'.$text.'"
									)');
				
			}
		}
		
		
		return;
	}

}