<?php

include_once '../../configuration.inc.php';

require_once PATH_CLASSES .'cl_customizing.php';
require_once PATH_CLASSES .'cl_language.php';

require_once PATH_FUNCTIONS .'database.php';
db_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

require_once PATH_FUNCTIONS .'general.php';

include_once PATH_INCLUDES .'database_tables.php';

/*
 *
* get all contracts that were terminated by customer and has today the expiration date
*
*/


if(db_num_results($query) > 0) {

	while($data = db_fetch_array($query)) {

		// get more information about contract
		$sql_statement = 'SELECT op.product_id, opd.server_id 
						  FROM '. TBL_CONTRACT .' AS co 
						  INNER JOIN '. TBL_ORDER_POSITION .' AS op 
						  	ON co.order_position_id = op.order_position_id 
						  INNER JOIN '. TBL_ORDER_POSITION_DETAIL .' AS opd 
						  	ON op.order_position_id = opd.order_position_id 
						  WHERE co.contract_id = '. (int) $data['contract_id'];
		
		$contract_details_query = db_query($sql_statement);
		
		if(db_num_results($contract_details_query) == 1) {
		
			$contract_details = db_fetch_array($contract_details_query);
			
			$contract = new contract($data['contract_id']);
			
			
		}
		else {
			break;
		}	

	}

}


/*
 *
*/

?>