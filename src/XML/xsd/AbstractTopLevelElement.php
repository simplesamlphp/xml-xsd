<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue, QNameValue, StringValue};
use SimpleSAML\XSD\Type\{BlockSetValue, DerivationSetValue};

/**
 * Abstract class representing the topLevelElement-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractTopLevelElement extends AbstractElement
{
    /**
     * Element constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|\SimpleSAML\XSD\XML\xsd\LocalComplexType|null $localType
     * @param array<\SimpleSAML\XSD\XML\xsd\IdentityConstraintInterface> $identityConstraint
     * @param \SimpleSAML\XML\Type\QNameValue|null $type
     * @param \SimpleSAML\XML\Type\QNameValue|null $substitutionGroup
     * @param \SimpleSAML\XML\Type\StringValue|null $default
     * @param \SimpleSAML\XML\Type\StringValue|null $fixed
     * @param \SimpleSAML\XML\Type\BooleanValue|null $nillable
     * @param \SimpleSAML\XML\Type\BooleanValue|null $abstract
     * @param \SimpleSAML\XSD\Type\DerivationSetValue|null $final
     * @param \SimpleSAML\XSD\Type\BlockSetValue|null $block
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        NCNameValue $name,
        LocalSimpleType|LocalComplexType|null $localType = null,
        array $identityConstraint = [],
        ?QNameValue $type = null,
        ?QNameValue $substitutionGroup = null,
        ?StringValue $default = null,
        ?StringValue $fixed = null,
        ?BooleanValue $nillable = null,
        ?BooleanValue $abstract = null,
        ?DerivationSetValue $final = null,
        ?BlockSetValue $block = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            name: $name,
            localType: $localType,
            identityConstraint: $identityConstraint,
            type: $type,
            substitutionGroup: $substitutionGroup,
            default: $default,
            fixed: $fixed,
            nillable: $nillable,
            abstract: $abstract,
            final: $final,
            block: $block,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
