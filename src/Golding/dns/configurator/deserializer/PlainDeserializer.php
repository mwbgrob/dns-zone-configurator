<?php
/**
 * @author: Viskov Sergey
 * @date  : 4/12/16
 * @time  : 1:00 PM
 */

namespace Golding\dns\configurator\deserializer;

use Golding\dns\configurator\Zone;
use Golding\dns\Tokenizer;

/**
 * Class PlainDeserializer
 *
 * @package Golding\dns\configurator\deserializer
 */
class PlainDeserializer
{
    /**
     * @param Zone   $zone
     * @param string $data
     * @return Zone
     */
    public static function deserialize(Zone $zone, string $data) : Zone
    {
        return ArrayDeserializer::deserialize($zone, Tokenizer::tokenize($data));
    }
}