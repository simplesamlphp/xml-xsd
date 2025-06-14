<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Type;

use SimpleSAML\XML\Type\TokenValue;

/**
 * @package simplesaml/xml-xsd
 */
class PublicValue extends TokenValue
{
    /** @var string */
    public const SCHEMA_TYPE = 'public';
}
