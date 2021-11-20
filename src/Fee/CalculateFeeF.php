<?php
declare(strict_types=1);


namespace Feecalc\Fee;
class CalculateFeeF
{

    private FileReaderInterface $fileReader;
    private TransactionHandler $transactionHandler;
   
    private $path;



    public function __construct(){
       
    }

    function execute(string $path){

     
            $transactionsData = $this->fileReader->read($path);

            foreach ($transactionsData as $transactionData) {
                $transactionRequest = new TransactionRequest();
                $transactionRequest
                    ->setUserId($transactionData[1])
                    ->setClientType($transactionData[2])
                    ->setDate($transactionData[0])
                    ->setOperationType($transactionData[3])
                    ->setCurrencyCode($transactionData[5])
                    ->setAmount($transactionData[4]);

                $this->transactionHandler->addTransaction($transactionRequest);
            }

        
       
    }
}