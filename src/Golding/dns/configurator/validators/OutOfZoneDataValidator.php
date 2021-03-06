<?php
/**
 * @author: Viskov Sergey
 * @date  : 7/15/16
 * @time  : 6:55 PM
 */

namespace Golding\dns\configurator\validators;

use Golding\dns\configurator\zoneEntities\Node;

/**
 * Class OutOfZoneDataValidator
 *
 * @package Golding\dns\configurator\validators
 */
class OutOfZoneDataValidator
{
    /**
     * @param Node $node
     * @return bool
     */
    public static function validate(Node $node) : bool
    {
        $origin   = $node->getZone()->getOrigin();
        $nodeName = $node->getName();

        if (substr($nodeName, -1) !== '.') {
            return true;
        }
        $pattern = "/{$origin}\.$/";
        if (preg_match($pattern, $nodeName)) {
            return true;
        }

        return false;
    }

}