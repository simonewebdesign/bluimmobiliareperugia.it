<?php
/** A PHP class to fetch a database's table in an object oriented way, with convenient methods for automatic paging and ordering of query results.
 * @version  1.3 - 08/06/2012
 * @author   Simone <info@simonewebdesign.it>
*/

class Table {

	var $db = null; // an active PDO connection
	
	var $table_name = '';
	var $query  	= '';
	var $result  = null; 	// a PDOStatement object
	
	var $rows 	 = array();
	var $columns = array();
	var $actions = array();
	
	var $order_by  	= '';
	var $order_type = '';	
	
	var $limit_offset 	 = 0; // start from
	var $limit_row_count = 0; // rows per page
	
	/** Constructor.
	* @param $db an active PDO connection.
	* @param $table_name the name of the table to be fetched.
	* @param $query the query to be executed. (optional)
	* @param $actions an array of actions to be performed. (optional)
	*/
	function __construct ( $db, $table_name, $query='', $actions=array('update' => 'Modifica', 'delete' => 'Cancella') ) {

		// defaults
		$ROWS_PER_PAGE = 20;
		$ORDER_TYPE = 'asc';

		$this->db = $db;
		$this->table_name = $table_name;
		
		$_SESSION['table_name'] 	= isset($_SESSION['table_name']) ? $_SESSION['table_name'] : $this->table_name;
		$_SESSION['rows_per_page'] 	= (int) ( isset($_SESSION['rows_per_page']) ? $_SESSION['rows_per_page'] : $ROWS_PER_PAGE );
		$_SESSION['start_from']	   	= $_SESSION['page'] * $_SESSION['rows_per_page'] - $_SESSION['rows_per_page'];
		$_SESSION['order_by'] 	   	= ( isset($_SESSION['order_by']) && $_SESSION['table_name'] == $this->table_name ) ? $_SESSION['order_by'] : false;
		$_SESSION['table_name'] 	= $this->table_name;
		$_SESSION['order_type']		= isset($_SESSION['order_type']) ? $_SESSION['order_type'] : $ORDER_TYPE;
		
		$this->order_by 			= $_SESSION['order_by'];
		$this->order_type 			= $_SESSION['order_type'];
		
		$this->limit_offset 		= $_SESSION['start_from'];
		$this->limit_row_count 		= $_SESSION['rows_per_page'];

		$this->query = empty($query) ? "SELECT * FROM `{$table_name}`" : $query;
		$this->query.= $this->order_by ? " ORDER BY `{$this->order_by}` {$this->order_type}" : ''; 
		$this->query.= " LIMIT {$this->limit_offset}, {$this->limit_row_count}";
//		var_dump($this->query);	
		$this->result = $db->query($this->query);
//		var_dump($this->result);
		$this->rows = $this->result->fetchAll(PDO::FETCH_OBJ); // fatal error from this row? 99% The query is WRONG. Debug it. Common error: don't use LIMIT or ORDER BY.
//		var_dump($this->rows);		
		$this->columns = empty($this->rows) ? array() : array_keys((array)$this->rows[0]);	//	this one works well even with objects, since it casts everything in (array) type.
//		var_dump($this->columns);
		$this->actions = empty($actions) ? array() : $actions;
//		var_dump($this->actions);
	}

	
	/** Get the result's number of rows. 
	* @return An integer representing the number of elements of the array $this->rows. In other words, the number of currently displayed elements in the current page. (same as getRowCount())
	*/	
	function getNumberOfRows () {
		return count($this->rows);
	}
	
	/** Get the row count.
	* @return An integer representing the total elements returned by the query result. (same as getNumberOfRows())
	*/	
	function getRowCount () {
		return $this->result->rowCount();
	}

	/** Get the total number of rows of the table. 
	* @return An integer representing the total number of records in the table.
	*/	
	function getTotalNumberOfRows () {
		$statement = $this->db->query("SELECT COUNT(*) FROM {$this->table_name}");
		$count = $statement->fetch(PDO::FETCH_NUM);
		return $count[0];
	}

	/** Get the total number of rows from the query result, but without limit (exactly as phpmyadmin does). 
	* @return An integer representing the number of records from the result.
	*/	
	function getNumberOfRowsFromResult () {
		$subject = $this->query;
		$search = ' LIMIT ';
		$replace = '; --';
		$query = str_replace($search, $replace, $subject);
		$statement = $this->db->query($query);
		return $statement->rowCount();
	}
	
	/** Get the possible/valid actions.
	* @return An associative array composed of $pure_action => $readable_action.
	*/
	function getActions () {
		return $this->actions;
	}

	/** Get the number of rows of the result. 
	* @return An integer representing the number of elements of the array $this->rows.
	*/	
	function getNumberOfActions () {
		return count($this->actions);
	}
	
	/** HTML <td>'s of the possible actions for a row.
	* @param $id an unique key. Usually it's the table's primary key.
	* @return HTML cells containing the actions.
	*/
	function actions ($id) {
		
		$html = '';
		
		if ( empty($this->actions) ) { 
			return $html; 
		}	

		if ( is_array($this->actions) ) {

			foreach ( $this->actions as $pure_action => $readable_action ) {

				$html.= '<td>';
					$html.= '<a ';
					$html.= 'href="' . ROOT . 
					'backoffice/' . $this->table_name .
					'/' . $pure_action .
					'/' . $id .
					'" ';
					$html.= 'class="action ' . $pure_action . '">';
					$html.= $readable_action;
					$html.= '</a>';
				$html.= '</td>';
			}
		}
		
		return $html;
	}	
	
	/** Get all the rows from the result.
	* @return an array containing the query result.
	*/
	function getRows () {
		return $this->rows;
	}

	/** Get the n-th row from the result.
	* @param $n the array bound of the row to retrieve. This could throw an ArrayOutOfBoundsException (?? we're not in Java lol)
	* @return On success, an array representing the row. On fail, false.
	*/	
	function getRow ($n) {
		// TODO
	
	}

	/** Get a specific row from the result.
	* @param $id the id of the row to retrieve.
	* @return An array representing the row.
	*/	
	function getRowById ($id) {
		// TODO
	}

	/** Get all the columns from the result.
	* @return an array containing the column names.
	*/	
	function getColumns () {
		return $this->columns;
	}
	
	/** Get a specific column from the result.
	* @param $column_name the name of the column to retrieve. NOTE: it needs to be lowercase. Remember that if, for example, the humanized name is "Creation date", the column name will be "creation_date".
	* @return An array representing the column.
	*/
	function getColumn ($column_name) {
		$column = array();
		foreach ( $this->rows as $row )
			$column[] = $row[$column_name];
		return $column;
	}
	
	/** HTML the <table>.
	* @return the HTML of the whole table.
	*/
	function table () {
	
		$table = '<table>';
		$table.= $this->thead();
		$table.= $this->tbody();
		$table.= '</table>';
		
		return $table;
	}
	
	/** HTML the <thead>.
	* @return the HTML head of the table, with all column names.
	*/
	function thead () {
	
		$order_type = $this->order_type == 'asc' ? 'desc' : 'asc';
	
		$head = '<thead>';
			$head.= '<tr>';
			foreach ( $this->columns as $column_name ) {
			
				$class = $this->order_by == $column_name ? 'icon ' . $this->order_type : '';
			
				$head.= '<th>';
					$head.= '<a class="' . $class . '" href="' . ROOT . 'backoffice/' . $this->table_name . '/order/' . $column_name . '/' . $order_type . '">' . humanize($column_name) . '</a>';
				$head.= '</th>';
			}
				$head.= empty($this->actions) ? '' : '<th colspan="'.$this->getNumberOfActions().'">Azioni</th>';
			$head.= '</tr>';
		$head.= '</thead>';
		
		return $head;
	}
	
	/** HTML the <tbody>.
	* @return the HTML body of the table, with all the table content.
	*/
	function tbody () {
		
		$body = '<tbody>';

		foreach ( $this->rows as $row ) {

			$body.= '<tr>';	

			foreach ( $row as $cell ) {
			
				$body.= '<td>' . $cell . '</td>';
			}
			
			$id = reset($row);
			$body.= $this->actions($id);
			
			$body.= '</tr>';
		}
		
		$body.= '</tbody>';
		
		return $body;
	}

	/** HTML the <tfoot>.
	* @return the HTML foot of the table, with custom content. In other words, this just wraps a custom content in the footer of a table.
	*/
	function tfoot ($content) {
		$foot = '<tfoot>';
		$foot.= $content;
		$foot.= '</tfoot>';
		return $foot;
	}
	
	/** HTML for navigating through the pages.
	* @return the navigator.
	*/	
	function pagesNavigator () {
		$html = '<div id=pages class=clearfix>';
			$pages = $this->getNumberOfPages();
			
			if ($_SESSION['page'] > 0) {
				if ($_SESSION['page'] > 1) {
					// we are not in the first page, so we print the first navigation arrows
					$prev_page = $_SESSION['page']-1;
					$html.= '<a href="' . ROOT . 'backoffice/' . $this->table_name . '/1"> &lt;&lt; </a>';				
					$html.= '<a href="' . ROOT . 'backoffice/' . $this->table_name . '/' . $prev_page . '"> &lt; </a>';
				}
				
				for ($i=1; $i <= $pages; $i++) {
				
					$html.= '<a ';
					if ($i == $_SESSION['page']) {
						$html.= 'class="current-page">'.$i.'</a>';
						continue;
					}
					$html.= 'href="' . ROOT . 'backoffice/' . $this->table_name . '/' . $i . '">' . $i . '</a>';
					
				}
				
				if ($_SESSION['page'] < $pages) {
					// we are not in the last page, so we print the last navigation arrows
					$next_page = $_SESSION['page']+1;
					$html.= '<a href="' . ROOT . 'backoffice/' . $this->table_name . '/' . $next_page . '"> &gt; </a>';
					$html.= '<a href="' . ROOT . 'backoffice/' . $this->table_name . '/' . $pages . '"> &gt;&gt; </a>';
				}
			}
			
		$html.= '</div>';
		return $html;
	}

	/** Get the number of pages from the result.
	* @return an integer representing the total number of pages.
	*/
	function getNumberOfPages () {
		return (int) ceil( $this->getNumberOfRowsFromResult() / $this->limit_row_count ); //= totale righe / righe da visualizzare  (arrotondato per eccesso)
	}
	
	/** HTML the informations about pagination, and the navigator, to navigate through pages.
	* @return navigation's informations.
	*/
	function paginate () {
		
		$html = '';
		
		if ( $this->getNumberOfRowsFromResult() > $this->limit_row_count ) {	
		
			$html.= '<span>';
			$html.= $this->getNumberOfRows();
			$html.= ' elementi visualizzati (Totale: ';
			$html.= $this->getNumberOfRowsFromResult();
			$html.= ')</span>';
			
			$html.= '<div>';
			$html.= 'Pagina ' . $_SESSION['page'] . ' di ' . $this->getNumberOfPages();
			$html.= $this->pagesNavigator();
			$html.= '</div>';
		}
		
		return $html;
	}

	/** Get the primary key name of the current table.
	* @return the name of the primary key.
	*/	
	function getPrimaryKeyName () {
		$query = "SHOW KEYS FROM {$this->table_name} WHERE Key_name = 'PRIMARY'";
		$result = $this->db->query($query);
		$key = $result->fetchObject();
		return $key->Column_name;
	}

	/** Get the column names from the current table.
	* @return the column names.
	*/		
	function getColumnNames () {
		$query = "SHOW COLUMNS FROM {$this->table_name}";
		$columns = $this->db->query($query);
		while ( $column = $columns->fetchObject() ) {
			$arr[] = $column->Field;
		}
		return $arr;
	}
	
	/** Just a wrapper for a <td>.
	* @param $value the value to wrap inside a cell.
	* @param $class optional CSS class.
	* @return the wrapped value.
	*/
	function cell ($value, $class='') {
		
		$html = "<td";
		$html.= empty($class) ? '' : " class='{$class}'";
		$html.= ">";
		$html.= $value;
		$html.= "</td>";
		
		return $html;
	}
}