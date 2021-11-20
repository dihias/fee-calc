<?php
declare(strict_types=1);


namespace Feecalc\Fee;
class CalculateFeeF
{

    private FileReaderInterface $fileReader;

    private LoggerInterface $logger;

    private TransactionHandler $transactionHandler;
    private TransactionHistoryManager $transactionHistoryManager;
    private CurrencyConfig $currencyConfig;
    private $path;



    public function __construct(){
       
    }

    function execute(string $path){

        try {
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

            $this->transactionHandler->handle();

            foreach ($this->transactionHandler->getOriginalTransactionOrder() as $transactionKey) {
                $processedTransaction = $this->transactionHistoryManager->get($transactionKey);
                $scale = $this->currencyConfig->getCurrencyScale($processedTransaction->getCurrencyCode());
                $fee = (float) $processedTransaction->getFee() / (pow(10, $scale));
                $output->write(number_format($fee, $scale, '.', ''), true);
            }
        } catch (Throwable $e) {
            $this->logger->critical(
                $e->getMessage().' thrown in '.$e->getFile().' on line '.$e->getLine()
            );

        }
       
    }
}