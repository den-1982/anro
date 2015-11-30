<?php
/*
*	ADMIN
*/
class materialsModel extends CI_Model
{
	public function getMaterials()
	{
		return $this->db->query('SELECT m.*,
										md.name
									FROM materials m
									LEFT JOIN materials_description md ON m.id = md.materials_id
								WHERE md.language_id = 1
									ORDER BY m.order ASC')->result();
	}
	
	public function getMaterial($id = 0)
	{
		$id = abs((int)$id);
		$material = $this->db->query('SELECT * FROM materials WHERE id = "'.$id.'"')->row();
		
		if ( ! $material) return array();
		
		# DESCRIPTION
		$material->description = array();
		$description = $this->db->query('SELECT md.*, 
												l.id AS language_id 
											FROM language l
											LEFT JOIN materials_description md 
												ON l.id = md.language_id 
												AND md.materials_id = "'.$material->id.'"')->result();
		
		foreach ($description as $k){
			$material->description[$k->language_id] = $k;
		}
		
		# IMAGES
		$material->images = $this->db->query('SELECT * FROM materials_images WHERE materials_id = "'.$material->id.'" ORDER BY `order` ASC')->result();
		foreach ($material->images as $k){
			
			$k->cache = preg_replace('/(.+)(\/.+)$/', '${1}/_cache_${2}', $k->image);
			
			$description = $this->db->query('SELECT mid.*, 
													l.id AS language_id 
												FROM language l
												LEFT JOIN materials_images_description mid 
													ON l.id = mid.language_id 
													AND mid.materials_images_id = "'.$k->id.'"')->result();
			foreach ($description as $j){
				$k->description[$j->language_id] = $j;
			}
		}
		
		return $material;
	}
	
	public function addMaterial()
	{
		# image
		$image	= isset($_POST['image']) ? clean($_POST['image'], false, true) : '';
		
		# ADD MATERIAL
		$this->db->query('INSERT INTO materials (image) 
							VALUES(
								"'.$image.'"
							)');
		
		# ID MATERIAL
		$id = $this->db->query('SELECT MAX(id) AS id FROM materials')->row()->id;
		
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
		$this->db->query('DELETE FROM materials_description WHERE materials_id = "'.$id.'"');
		// а что если $insert пустой ??????
		if ($insert){
			$this->db->query('INSERT INTO materials_description (materials_id, language_id, name, h1, title, metadesc, metakey, text) 
							VALUES '. implode($insert, ','));
		}
		

		# IMAGES
		if (isset($_POST['images']['insert'])) foreach ($_POST['images']['insert'] as $k=>$v){

			$order	= isset($_POST['images_order']['insert'][$k])	? abs((int)$_POST['images_order']['insert'][$k]) : 0;
			$img 	= isset($_POST['images']['insert'][$k])			? clean($_POST['images']['insert'][$k], true, true) : 0;
			
			if ( ! $img) continue;
			
			# INSERT IMAGES
			$this->db->query('INSERT INTO materials_images (materials_id, image, `order`) 
								VALUES(
									"'.$id.'",
									"'.$img.'",
									"'.$order.'"
								)');
			
			# get id_iamge
			$id_image = $this->db->query('SELECT MAX(id) AS id FROM materials_images')->row()->id;
			
			if (isset($_POST['images_description']['insert'][$k])) foreach ($_POST['images_description']['insert'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['images_description']['insert'][$k][$l]['h1'])		? clean($_POST['images_description']['insert'][$k][$l]['h1'], true, true) : '';
				$name		= isset($_POST['images_description']['insert'][$k][$l]['name'])		? clean($_POST['images_description']['insert'][$k][$l]['name'], true, true) : '';
				$title		= isset($_POST['images_description']['insert'][$k][$l]['title'])	? clean($_POST['images_description']['insert'][$k][$l]['title'], true, true) : '';
				$metadesc	= isset($_POST['images_description']['insert'][$k][$l]['metadesc']) ? clean($_POST['images_description']['insert'][$k][$l]['metadesc'], true, true) : '';
				$metakey	= isset($_POST['images_description']['insert'][$k][$l]['metakey'])	? clean($_POST['images_description']['insert'][$k][$l]['metakey'], true, true) : '';
				$text		= isset($_POST['images_description']['insert'][$k][$l]['text']) 	? clean($_POST['images_description']['insert'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO materials_images_description (materials_images_id, language_id, name, h1, title, metadesc, metakey, text) 
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
	
	public function editMaterial()
	{
		# ID PAGE
		$id		= isset($_POST['id'])		? abs((int)$_POST['id']) : 0;
		$image	= isset($_POST['image'])	? clean($_POST['image'], false, true) : '';
		
		$this->db->query('UPDATE materials SET image = "'.$image.'" WHERE id = "'.$id.'"');
		
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
		$this->db->query('DELETE FROM materials_description WHERE materials_id = "'.$id.'"');
		// а что если $insert пустой ??????
		if ($insert){
			$this->db->query('INSERT INTO materials_description (materials_id, language_id, name, h1, title, metadesc, metakey, text) 
							VALUES '. implode($insert, ','));
		}
		

		# IMAGES
		$this->db->query('DELETE FROM materials_images WHERE materials_id = "'.$id.'"');
		if (isset($_POST['images']['update'])) foreach ($_POST['images']['update'] as $k=>$v){
			$id_image = abs((int)$k);
			
			$order	= isset($_POST['images_order']['update'][$k])	? abs((int)$_POST['images_order']['update'][$k]) : 0;
			$img 	= isset($_POST['images']['update'][$k])			? clean($_POST['images']['update'][$k], true, true) : '';
			
			if ( ! $img) continue;
			
			# INSERT IMAGES
			$this->db->query('INSERT INTO materials_images (id, materials_id, image, `order`) 
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
				
				$this->db->query('INSERT INTO materials_images_description (materials_images_id, language_id, name, h1, title, metadesc, metakey, text) 
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
			$this->db->query('INSERT INTO materials_images (materials_id, image, `order`) 
								VALUES(
									"'.$id.'",
									"'.$img.'",
									"'.$order.'"
								)');
			
			# get id_iamge
			$id_image = $this->db->query('SELECT MAX(id) AS id FROM materials_images')->row()->id;
			
			if (isset($_POST['images_description']['insert'][$k])) foreach ($_POST['images_description']['insert'][$k] as $l=>$i){
				$language_id = abs((int)$l);
				
				$h1			= isset($_POST['images_description']['insert'][$k][$l]['h1'])		? clean($_POST['images_description']['insert'][$k][$l]['h1'], true, true) : '';
				$name		= isset($_POST['images_description']['insert'][$k][$l]['name'])		? clean($_POST['images_description']['insert'][$k][$l]['name'], true, true) : '';
				$title		= isset($_POST['images_description']['insert'][$k][$l]['title'])	? clean($_POST['images_description']['insert'][$k][$l]['title'], true, true) : '';
				$metadesc	= isset($_POST['images_description']['insert'][$k][$l]['metadesc']) ? clean($_POST['images_description']['insert'][$k][$l]['metadesc'], true, true) : '';
				$metakey	= isset($_POST['images_description']['insert'][$k][$l]['metakey'])	? clean($_POST['images_description']['insert'][$k][$l]['metakey'], true, true) : '';
				$text		= isset($_POST['images_description']['insert'][$k][$l]['text']) 	? clean($_POST['images_description']['insert'][$k][$l]['text'], false, true) : '';
				
				$this->db->query('INSERT INTO materials_images_description (materials_images_id, language_id, name, h1, title, metadesc, metakey, text) 
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
	
	
	public function setOrderMaterials()
	{
		for ($i = 0, $cnt = count($_POST['materials_order']); $i < $cnt; $i++){
			$id = isset($_POST['materials_id'][$i]) ? abs((int)$_POST['materials_id'][$i]) : 0;
			$order = abs((int)$_POST['materials_order'][$i]);
			
			$this->db->query('UPDATE materials SET `order` = '.$order.' WHERE id = '.$id);
		}
		return;
	}
	
	public function setVisibilityMaterial()
	{
		$id		= isset($_POST['id']) ? abs((int)$_POST['id']): 0;
		$activ	= (int)$_POST['activ'] ? 0 : 1;
		
		$this->db->query('UPDATE materials SET visibility = '.$activ.' WHERE id = '.$id);
		
		return $activ;
	}
	
	public function delMaterial($id = 0)
	{
		$id = abs((int)$id);
		$this->db->query('DELETE FROM materials WHERE id = "'.$id.'"');
	}

}