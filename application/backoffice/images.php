<h2>Immagini</h2>

<?php

// uploaded images paths (incollato come riferimento)
//define('ORIGINAL',  'img/uploaded/original/');
//define('GALLERY',	'img/uploaded/gallery/');
//define('PREVIEW',	'img/uploaded/preview/');

if ( isset($_POST['submit']) ) {

	$verbose[] = "[images] form submitted.";
	
	// hidden fields
	$action			= $_POST['action'];
	$_id 			= isset($_POST['id']) ? $_POST['id'] : 0; // property_id
	
	// fields
	$isMain	 	 = (int) (isset($_POST['isMain']) ? 1 : 0);
	$title 		 = isset($_POST['title']) ? trim($_POST['title']) : '';
	$description = isset($_POST['image_description']) ? trim($_POST['image_description']) : '';	// chiamato diversamente per evitare che si carichi tinymce
		
	/*** IMAGE UPLOAD -- tratto dall'image_scale_test ***/
	$image = $_FILES['image'];//isset($_FILES['image']) ? $_FILES['image'] : 'Immagine non caricata.';

	/* reference from settings:
	$settings['image']['preview_max_width'];
	$settings['image']['preview_max_height'];
	$settings['image']['portrait_max_width'];
	$settings['image']['portrait_max_height'];	
	$settings['image']['quality'];
	*/	
	
	if ( is_uploaded_file($image['tmp_name']) ) {

		// inizio blocco 0
		
		$verbose[] = "[images] a file has been uploaded.";
		// Controllo che il file non superi il limite
		if ( $image['size'] > FILESIZE_2MB ) {
		
			$verbose[] = "[images][ERROR] file too big.";
			$negative = "L'immagine scelta è troppo grande per essere caricata.";
			$response = $negative;
			
		} else {
			// inizio blocco1
			
			$verbose[] = "[images] File size is OK.";
			// Ottengo le informazioni sull'immagine
			list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);
			// Controllo che il file sia in uno dei formati GIF, JPG o PNG
			// Chiaramente deve essere diverso da tutti questi 3 formati contemporaneamente per dare errore
			
			if ( ($type!=1) && ($type!=2) && ($type!=3) ) {
				
				$verbose[] = "[images][ERROR] File format unacceptable. $type";
				$negative = "L'immagine non è stata caricata poiché non è in un formato accettabile (GIF, JPG, PNG).";
				$response = $negative;
				
			} else {
				// inizio blocco 2
				
				$verbose[] = "[images] File format acceptable.";
				$verbose[] = "[images] Establilishing current file format...";
				// stabilisco l'estensione del nome del file da salvare
				if ($type == 1) {$ext = ".gif";}
				if ($type == 2) {$ext = ".jpg";}
				if ($type == 3) {$ext = ".png";}
				$verbose[] = "[images] File format is '$ext'.";

				// Calcolo le nuove dimensioni per PREVIEW
				$verbose[] = "[images] Calculating width and height for PREVIEW (that is thumbnail also)...";
				$ratio = min( $settings['image']['preview_max_width'] / $width, 
							  $settings['image']['preview_max_height'] / $height 
							);
				$preview_new_width 	= round($ratio * $width);
				$preview_new_height = round($ratio * $height);
				$verbose[] = "[images] New width: $preview_new_width";
				$verbose[] = "[images] New height: $preview_new_height";

				// Calcolo le nuove dimensioni per PORTRAIT
				$verbose[] = "[images] Calculating width and height for PORTRAIT (gallery)...";
				$ratio = min( $settings['image']['portrait_max_width'] / $width, 
							  $settings['image']['portrait_max_height'] / $height 
							);
				$portrait_new_width  = round($ratio * $width);
				$portrait_new_height = round($ratio * $height);
				$verbose[] = "[images] New width: $portrait_new_width";
				$verbose[] = "[images] New height: $portrait_new_height";
				
				// creo la nuova immagine PREVIEW
				$verbose[] = "[images] Creating placeholder for new image (PREVIEW)...";
				$image_placeholder_preview = imagecreatetruecolor($preview_new_width, $preview_new_height);
				$preview_image = null;
				if ($type == 1) {
					$preview_image = imagecreatefromgif($image['tmp_name']);
				} 
				if ($type == 2) {
					$preview_image = imagecreatefromjpeg($image['tmp_name']);
				}
				if ($type == 3) {
					$preview_image = imagecreatefrompng($image['tmp_name']);
				}
				$verbose[] = "[images] Image placeholder PREVIEW created.";

				// creo la nuova immagine PORTRAIT
				$verbose[] = "[images] Creating placeholder for new image (PORTRAIT)...";
				$image_placeholder_portrait = imagecreatetruecolor($portrait_new_width, $portrait_new_height);
				$portrait_image = null;
				if ($type == 1) {
					$portrait_image = imagecreatefromgif($image['tmp_name']);
				} 
				if ($type == 2) {
					$portrait_image = imagecreatefromjpeg($image['tmp_name']);
				}
				if ($type == 3) {
					$portrait_image = imagecreatefrompng($image['tmp_name']);
				}
				$verbose[] = "[images] Image placeholder PORTRAIT created.";
				
				// resizing image (uso imagecopyresampled() perché la qualità è migliore)
				// bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
				//PREVIEW
				$verbose[] = "[images] Resizing PREVIEW...";
				imagecopyresampled( $image_placeholder_preview, $preview_image, 0,0,0,0, $preview_new_width, $preview_new_height, $width, $height );
				$verbose[] = "[images] PREVIEW resized successfully.";
				//PORTRAIT
				$verbose[] = "[images] Resizing PORTRAIT...";
				imagecopyresampled( $image_placeholder_portrait, $portrait_image, 0,0,0,0, $portrait_new_width, $portrait_new_height, $width, $height );
				$verbose[] = "[images] PORTRAIT resized successfully.";
				
				$verbose[] = "[images] Estabilishing image name...";
				// L'immagine è perfetta per essere caricata così com'è sul server.
				// Nome immagine che verrà caricata:
				$image_name = uniqid().$ext;
				$verbose[] = "[images] Image name estabilished.";
				$verbose[] = "[images] Image name: $image_name";
				
				// Procedo con l'upload dell'immagine originale
				$verbose[] = "[images] Trying uploading ORIGINAL image...";
				
				if ( move_uploaded_file($image['tmp_name'] , ORIGINAL . $image_name) ) {
				
					// inizio blocco 3
				
					$verbose[] = "[images] ORIGINAL image successfully uploaded!";
				
					// Procedo con l'upload delle altre immagini,
					// ma prima unsetto l'originale $image per liberare un po' di memoria
					$verbose[] = "[images] Unsetting original image, just to free some memory...";
					unset($image);
					$verbose[] = "[images] Image unsetted.";
					
					$verbose[] = "[images] Trying uploading PREVIEW image...";
					// bool imagejpeg ( resource $image [, string $filename [, int $quality ]] ) -- http://php.net/manual/en/function.imagejpeg.php
					if ( imagejpeg($image_placeholder_preview, PREVIEW . $image_name, $settings['image']['quality']) ) {
						$verbose[] = "[images] PREVIEW image successfully uploaded!";
					} else {
						$verbose[] = "[images][error] PREVIEW image not uploaded.";						
					}
					
					$verbose[] = "[images] Trying uploading PORTRAIT image...";
					// bool imagejpeg ( resource $image [, string $filename [, int $quality ]] ) -- http://php.net/manual/en/function.imagejpeg.php
					if ( imagejpeg($image_placeholder_portrait, PORTRAIT . $image_name, $settings['image']['quality']) ) {
						$verbose[] = "[images] PORTRAIT image successfully uploaded!";
					} else {
						$verbose[] = "[images][error] PORTRAIT image not uploaded.";
					}
						
					if ( $isMain > 0 ) {
						$verbose[] = "[images] Setting image as main...";
						$clean_main_image_query = "UPDATE images SET isMain = 0 WHERE property_id = '$_id'";
						$db->exec($clean_main_image_query);
						$verbose[] = "[images] done.";
					}
					
					$sql_data = array(
						'property_id'	=> $_id,
						'name'			=> $image_name,
						'isMain'		=> $isMain,
						'title'			=> $title,
						'description'	=> $description
					);
					
					$query_string = "INSERT INTO images (name, property_id, uploadDate, isMain, title, description) VALUES (:name, :property_id, NOW(), :isMain, :title, :description)";
					$statement = $db->prepare($query_string);
					if ( $statement->execute($sql_data) ) {
						$positive = "Immagine inserita con successo.";
						$negative = "";
						$response = $positive;
					} else {
						$positive = "";
						$negative = "Errore durante il salvataggio dell'immagine.";
						$response = $negative;
					}
					
				} else {
					$verbose[] = "[images][ERROR] ORIGINAL image not uploaded.";
					$negative = "È avvenuto un errore durante l'upload dell'immagine.";
					$response = $negative;
				} // fine blocco 3	
			} // fine blocco 2
		} // fine blocco1
	} // fine blocco 0
} // submit