<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

/**
 * Class representing the enumeration element
 *
 * @package simplesamlphp/xml-xsd
 */
final class Enumeration extends AbstractNoFixedFacet implements SchemaValidatableElementInterface, FacetInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'enumeration';
}
