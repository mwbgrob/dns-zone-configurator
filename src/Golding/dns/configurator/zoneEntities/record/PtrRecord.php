<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/12/16
 * @time  : 1:00 PM
 */

namespace Golding\dns\configurator\zoneEntities\record;

use Golding\dns\configurator\errors\ValidationError;
use Golding\dns\configurator\validators\DnsZoneDomainNameValidator;
use Golding\dns\configurator\validators\PtrValidator;
use Golding\dns\configurator\zoneEntities\Node;
use Golding\dns\configurator\zoneEntities\record\base\Record;
use Golding\dns\enums\eErrorCode;
use Golding\dns\enums\eRecordType;

/**
 * Class PtrRecord
 *
 * @package Golding\dns\configurator\zoneEntities\record
 */
class PtrRecord extends Record
{
    /**
     * @var String
     */
    protected $ptrDName;

    /**
     * PtrRecord constructor.
     *
     * @param Node   $node
     * @param int    $ttl
     * @param string $ptrDName
     */
    public function __construct(Node $node, int $ttl, string $ptrDName)
    {
        $this->ptrDName = $ptrDName;
        parent::__construct($node, eRecordType::PTR(), $ttl);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->getMainRecordPart() . " {$this->getPtrDName()}";
    }

    /**
     * @return String
     */
    public function getPtrDName()
    {
        return $this->ptrDName;
    }

    /**
     * @param String $ptrDName
     */
    public function setPtrDName(string $ptrDName)
    {
        $this->setAttribute('ptrDName', $ptrDName);
    }

    /**
     * @internal
     * @return bool
     */
    public function validate() : bool
    {
        $errorStorage = $this->getNode()->getZone()->getErrorsStore();

        if (!PtrValidator::validate($this->getPtrValue())) {
            $errorStorage->add(ValidationError::makeRecordError($this, eErrorCode::WRONG_PTR_NAME(), 'ptrName'));
        }

        if (!DnsZoneDomainNameValidator::validate($this->getPtrDName())) {
            $errorStorage->add(ValidationError::makeRecordError($this, eErrorCode::WRONG_DOMAIN_NAME(), 'ptrDName'));
        }

        /** @noinspection PhpInternalEntityUsedInspection */
        return parent::validate();
    }

    /**
     * @return string
     */
    private function getPtrValue() : string
    {
        return "{$this->getNode()->getName()}.{$this->getNode()->getZone()->getOrigin()}.";
    }

    /**
     * @return array
     */
    protected function recordDataToArray() : array
    {
        return [
            'PTRDNAME' => $this->getPtrDName()
        ];
    }
}