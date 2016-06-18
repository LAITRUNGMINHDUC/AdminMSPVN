<?php
namespace App\Classes;

/* Include all Azure Storage File */
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Table\Models\BatchOperations;	
use MicrosoftAzure\Storage\Table\Models\Entity;
use MicrosoftAzure\Storage\Table\Models\EdmType;
use MicrosoftAzure\Storage\Queue\Models\CreateQueueOptions;
use MicrosoftAzure\Storage\Queue\Models\PeekMessagesOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
/* ----------------------------- */

class CustomAzure
{
	/* Get the Private Key of Azure Storage */
	public $connectionString;
	public $tableClient;

	public function __construct()
	{
		$this->connectionString = env('AZURE_KEY');
		$this->tableClient = ServicesBuilder::getInstance()->createTableService($this->connectionString);
	}

	/* For Table Storage */
	public function createTable($tableName)
	{
	    try {	        
	        $this->tableClient->createTable($tableName);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();	        
	    }

	    if (!empty($code))
	    {
	    	$noti['notification'] = "Error";
	    	$noti['code'] = $code;
	    	$noti['error_message'] = $error_message;	    	
	    }
	    else
	    {
	    	$noti['notification'] = "Task OK -> No error";
	    }

	    return $noti;
	}

	public function insertEntity($tableName, $Input)
	{
	    $entity = new Entity();
	    $entity->setPartitionKey($Input['PartitionKey']);
	    $entity->setRowKey($Input['RowKey']);

	    foreach ($Input['Data'] as $key => $value) {
	    	$entity->addProperty($key, EdmType::STRING, $value);
	    }	    
	    
	    try{
	        $this->tableClient->insertEntity($tableName, $entity);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();	      
	    }

	    if (!empty($code))
	    {
	    	$noti['notification'] = "Error";
	    	$noti['code'] = $code;
	    	$noti['error_message'] = $error_message;	    	
	    }
	    else
	    {
	    	$noti['notification'] = "Task OK -> No error";
	    }

	    return $noti;
	}

	public function ConvertEntities($entities)
	{
		$jsonArray = array();
		for ($i = 0; $i < count($entities); $i++) {
            $arr = $entities[$i]->getProperties();
            $tempArr = array();
            foreach ($arr as $key => $value) {
                if(gettype($entities[$i]->getPropertyValue($key)) != 'object'){
                    $tempArr[$key] = (string)$entities[$i]->getPropertyValue($key);                 }
				else
                {
	                $tempArr[$key] = serialize($entities[$i]->getPropertyValue($key));
	            }
	        }
	        array_push($jsonArray, $tempArr);
	        }		
		return $jsonArray;	        
	}

	public function queryEntities($tableName, $query)
	{
	    $filter = $query;
	    
	    try {
	        $result = $this->tableClient->queryEntities($tableName, $filter);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();	        
	    }
	    return $this->ConvertEntities($result->getEntities());
	}
}
?>