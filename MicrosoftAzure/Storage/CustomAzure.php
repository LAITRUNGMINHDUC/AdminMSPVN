<?php
namespace MicrosoftAzure\Storage;

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
	private static $connectionString = env('AZURE_KEY');

	public static $Test = "Love";

	/* For Table Storage */
	private static $tableClient = ServicesBuilder::getInstance()->createTableService($this->connectionString);

	public function createTable($tableName)
	{
	    try {	        
	        $this->tableClient->createTable($tableName);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();
	        echo $code.": ".$error_message.PHP_EOL;
	    }
	}

	public function insertEntity($tableName, $PartitionKey, $RowKey, $PropertyName, $Value)
	{
	    $entity = new Entity();
	    $entity->setPartitionKey($PartitionKey);
	    $entity->setRowKey($RowKey);
	    $entity->addProperty($PropertyName, EdmType::STRING, $Value);
	    
	    try{
	        $this->tableClient->insertEntity($tableName, $entity);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();
	        echo $code.": ".$error_message.PHP_EOL;
	    }
	}

	public function query($tableName, $query)
	{
	    $filter = $query;
	    
	    try {
	        $result = $this->tableClient->queryEntities($tableName, $filter);
	    } catch(ServiceException $e){
	        $code = $e->getCode();
	        $error_message = $e->getMessage();
	        echo $code.": ".$error_message.PHP_EOL;
	    }
	    
	    $entities = $result->getEntities();
	    
	    foreach($entities as $entity){
	        echo $entity->getPartitionKey().":".$entity->getRowKey().PHP_EOL;
	    }		
	}
}
?>