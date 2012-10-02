<div id=pages>
	<div class=clearfix>
<?php
	$pages = (int) ceil( $all_properties->rowCount() / $settings['results']['default_limit'] );
	//echo "pages:";var_dump($pages);
	
	if ( $all_properties->rowCount() > $settings['results']['default_limit'] ) {
		if ($page > 0) {
			// we are not in the first page, so we print the first navigation arrows
			$prev_page = $page-1;
			$url = ROOT;
			$url.= 'ricerca';					  // template_name
			$url.= isset($get[1]) ? '/'.$get[1] : '/0'; // type_id
			$url.= isset($get[2]) ? '/'.$get[2] : '/0'; // contract_id
			$url.= isset($get[3]) ? '/'.$get[3] : '/0'; // id_frazione
			$url.= isset($get[4]) ? '/'.$get[4] : '/0'; // id_comune
			$url.= isset($get[5]) ? '/'.$get[5] : '/0_0'; // prices
			$url.= isset($get[6]) ? '/'.$get[6] : '/0_0'; // surfaces
			$url.= isset($get[7]) ? '/'.$get[7] : '/0'; // cantieri
//			$url.= isset($get[8]) ? '/'.$get[8] : '/'.$page; // page
			$url.= '/';
			//debug:var_dump($url);
			
			if ($page > 1) {
				
				echo '<a href="' . $url . 1 . '"> &lt;&lt; </a>';
				echo '<a href="' . $url . $prev_page . '" class="prevpage"> &lt; </a>';
			}
			
			for ($i=1; $i <= $pages; $i++) {
			
				echo '<a ';
				if ($i == $page) {
					echo 'class="current-page">'.$i.'</a>';
					continue;
				}
				echo 'href="'.$url.$i.'">'.$i.'</a>';

			}
			
			if ($page < $pages) {
				// we are not in the last page, so we print the last navigation arrows
				$next_page = $page+1;
				echo '<a href="' . $url . $next_page . '" class="nextpage"> &gt; </a>';
				echo '<a href="' . $url . $pages . '"> &gt;&gt; </a>';
			}
		}
	}
?>
	</div>
</div>
