<?php


namespace puresoft\jibimo\models;


use puresoft\jibimo\exceptions\InvalidJibimoPrivacyLevel;
use puresoft\jibimo\exceptions\InvalidJibimoTransactionStatus;
use puresoft\jibimo\exceptions\InvalidMobileNumberException;
use puresoft\jibimo\internals\DataNormalizer;

class RequestTransactionResponse extends AbstractTransactionResponse
{

    private $payer;
    private $redirect;

    /**
     * RequestTransactionResponse constructor.
     * @param string $raw
     * @param int $transactionId
     * @param string $trackerId
     * @param int $amount
     * @param string $payer
     * @param string $privacy
     * @param string $status
     * @param string $createdAt
     * @param string $updatedAt
     * @param string $redirect
     * @param string|null $description
     * @throws InvalidJibimoPrivacyLevel
     * @throws InvalidMobileNumberException
     * @throws InvalidJibimoTransactionStatus
     */
    public function __construct(string $raw, int $transactionId, string $trackerId, int $amount, string $payer,
                                string $privacy, string $status, string $createdAt, string $updatedAt, string $redirect,
                                ?string $description = null)
    {
        parent::__construct($raw, $transactionId, $trackerId, $amount, $privacy, $status, $createdAt,
            $updatedAt, $description);

        $this->payer = DataNormalizer::normalizeMobileNumber($payer);
        $this->redirect = $redirect;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirect;
    }

    /**
     * @return string
     * @throws InvalidMobileNumberException
     */
    public function getPayer(): string
    {
        return DataNormalizer::normalizeMobileNumber($this->payer);
    }

}