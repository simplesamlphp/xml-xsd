<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class to be implemented by all the classes that use the openAttrs complex type
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractOpenAttrs extends AbstractAnyType
{
    /** The namespace-attribute for the xs:any element */
    public const XS_ANY_ELT_NAMESPACE = [];

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * AbstractAnyType constructor
     *
     * @param array<\SimpleSAML\XML\Attribute> $attributes
     */
    public function __construct(
        array $attributes = [],
    ) {
        /**
         * NOTE: no elements allowed here:
         *
         * @see XML Schema specification (Part 1, Section 3.4.2)
         *
         * If no content model is specified in a restriction, the content model is effectively empty
         * for elements unless mixed content is explicitly allowed.
         */
        parent::__construct([], $attributes);
    }
}
