<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Type\NonNegativeIntegerValue;

/**
 * @package simplesaml/xml-xsd
 */
class MinOccursValue extends NonNegativeIntegerValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'minOccurs';
}
