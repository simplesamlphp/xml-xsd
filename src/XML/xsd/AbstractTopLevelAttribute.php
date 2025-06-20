<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue, StringValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class representing the topLevelAttribute-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractTopLevelAttribute extends AbstractAttribute
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * TopLevelAttribute constructor
     *
     * @param \SimpleSAML\XML\Type\QNameValue $type
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XML\Type\StringValue|null $default
     * @param \SimpleSAML\XML\Type\StringValue|null $fixed
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|null $simpleType
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        QNameValue $type,
        NCNameValue $name,
        ?StringValue $default = null,
        ?StringValue $fixed = null,
        ?LocalSimpleType $simpleType = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            name: $name,
            type: $type,
            default: $default,
            fixed: $fixed,
            simpleType: $simpleType,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
