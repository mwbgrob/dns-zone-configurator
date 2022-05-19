<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/12/16
 * @time  : 1:31 PM
 */

namespace Golding\dns\configurator\traits;

use BadMethodCallException;
use InvalidArgumentException;
use Golding\dns\configurator\zoneEntities\record\AaaaRecord;
use Golding\dns\configurator\zoneEntities\record\ARecord;
use Golding\dns\configurator\zoneEntities\record\base\Record;
use Golding\dns\configurator\zoneEntities\record\CnameRecord;
use Golding\dns\configurator\zoneEntities\record\CaaRecord;
use Golding\dns\configurator\zoneEntities\record\MxRecord;
use Golding\dns\configurator\zoneEntities\record\NsRecord;
use Golding\dns\configurator\zoneEntities\record\PtrRecord;
use Golding\dns\configurator\zoneEntities\record\SoaRecord;
use Golding\dns\configurator\zoneEntities\record\SrvRecord;
use Golding\dns\configurator\zoneEntities\record\TxtRecord;
use Golding\dns\enums\eRecordType;

/**
 * Class RecordsIterateTrait
 *
 * @package Golding\dns\configurator\tarits
 * @method ARecord[] iterateA()
 * @method AaaaRecord[] iterateAaaa()
 * @method CnameRecord[] iterateCname()
 * @method MxRecord[] iterateMx()
 * @method NsRecord[] iterateNs()
 * @method PtrRecord[] iteratePtr()
 * @method SoaRecord[] iterateSoa()
 * @method SrvRecord[] iterateSrv()
 * @method TxtRecord[] iterateTxt()
 * @method CaaRecord[] iterateCaa()
 */
trait RecordsIterateTrait
{
    /**
     * @internal
     * @param $name
     * @param $arguments
     * @return Record[]
     */
    public function __call($name, $arguments)
    {
        try {
            $type = eRecordType::get(mb_strtoupper(str_replace('iterate', '', $name)));

            return $this->iterateRecords($type);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException("Method {$name} not found");
        }
    }

    /**
     * @param eRecordType $type
     * @return mixed
     */
    abstract public function iterateRecords(eRecordType $type);
}