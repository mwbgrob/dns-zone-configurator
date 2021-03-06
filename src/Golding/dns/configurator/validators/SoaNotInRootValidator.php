<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/12/16
 * @time  : 1:00 PM
 */

namespace Golding\dns\configurator\validators;

use Golding\dns\configurator\zoneEntities\record\SoaRecord;

/**
 * Class SoaNotInRootValidator
 *
 * @package beget\lib\dns\lib\validators
 */
class SoaNotInRootValidator
{
    /**
     * @param SoaRecord $record
     * @return bool
     */
    public static function validate(SoaRecord $record) : bool 
    {
        return $record->getNode()->getName() === '@';
    }
}