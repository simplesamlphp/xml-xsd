<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\AbstractElement;
use SimpleSAML\XML\Constants as C;

/**
 * Abstract class to be implemented by all the classes in this namespace
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractXsdElement extends AbstractElement
{
    /** @var string */
    public const NS = C::NS_XS;

    /** @var string */
    public const NS_PREFIX = 'xsd';

    /** @var string */
    public const SCHEMA = 'resources/schemas/XMLSchema.xsd';
}
