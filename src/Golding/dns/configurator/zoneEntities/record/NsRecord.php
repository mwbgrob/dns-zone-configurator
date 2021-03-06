<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/12/16
 * @time  : 1:00 PM
 */

namespace Golding\dns\configurator\zoneEntities\record;

use Golding\dns\configurator\errors\ValidationError;
use Golding\dns\configurator\validators\DnsZoneDomainNameValidator;
use Golding\dns\configurator\zoneEntities\Node;
use Golding\dns\configurator\zoneEntities\record\base\Record;
use Golding\dns\enums\eErrorCode;
use Golding\dns\enums\eRecordType;

/**
 * Class NsRecord
 *
 * @package Golding\dns\configurator\zoneEntities\record
 */
class NsRecord extends Record
{
    /**
     * @var String
     */
    protected $nsdName;

    /**
     * NsRecord constructor.
     *
     * @param Node   $node
     * @param int    $ttl
     * @param string $nsdName
     */
    public function __construct(Node $node, $ttl, string $nsdName)
    {
        $this->nsdName = $nsdName;
        parent::__construct($node, eRecordType::NS(), $ttl);
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return $this->getMainRecordPart() . " {$this->getNsdName()}";
    }

    /**
     * @return String
     */
    public function getNsdName() : string
    {
        return $this->nsdName;
    }

    /**
     * @param String $nsdName
     */
    public function setNsdName(string $nsdName)
    {
        $this->setAttribute('nsdName', $nsdName);
    }

    /**
     * @internal
     * @return bool
     */
    public function validate() : bool
    {
        $errorStorage = $this->getNode()->getZone()->getErrorsStore();

        if (!DnsZoneDomainNameValidator::validate($this->getNsdName())) {
            $errorStorage->add(ValidationError::makeRecordError($this, eErrorCode::WRONG_DOMAIN_NAME(), 'nsdName'));
        }

        /** @noinspection PhpInternalEntityUsedInspection */
        return parent::validate();
    }

    /**
     * @return array
     */
    protected function recordDataToArray() : array
    {
        return [
            'NSDNAME' => $this->getNsdName()
        ];
    }
}