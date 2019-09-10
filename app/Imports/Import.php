<?php


namespace App\Imports;

use App\Exceptions\ImportException;
use App\Exceptions\InvalidContentException;


abstract class Import implements ImportInterface
{

    protected $stopOnError = false;

    /**
     * @param Object $ownerData
     * @param string $message
     * @return boolean
     * @throws ImportException
     */
    public function validate(Object $ownerData, string $message): bool
    {
        if (!$ownerData->valid || !isset($ownerData->result->id)) {

            if ($this->stopOnError) {
                throw new ImportException($message .
                    implode('. ', (array)$ownerData->errors->all()));
            }
        }
        return $ownerData->valid;
    }

    /**
     * @return bool
     */
    public function isStopOnError(): bool
    {
        return $this->stopOnError;
    }

    /**
     * @param bool $stopOnError
     */
    public function setStopOnError(bool $stopOnError): void
    {
        $this->stopOnError = $stopOnError;
    }

}