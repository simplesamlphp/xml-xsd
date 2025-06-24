<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue, QNameValue, StringValue};
use SimpleSAML\XSD\Type\{BlockSetValue, DerivationSetValue, FormChoiceValue, MinOccursValue, MaxOccursValue};

/**
 * Abstract class representing the localElement-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractLocalElement extends AbstractElement
{
    /**
     * Element constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     * @param \SimpleSAML\XML\Type\QNameValue|null $reference
     * @param \SimpleSAML\XSD\XML\xsd\LocalSimpleType|\SimpleSAML\XSD\XML\xsd\LocalComplexType|null $localType
     * @param array<\SimpleSAML\XSD\XML\xsd\IdentityConstraintInterface> $identityConstraint
     * @param \SimpleSAML\XML\Type\QNameValue|null $type
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     * @param \SimpleSAML\XML\Type\StringValue|null $default
     * @param \SimpleSAML\XML\Type\StringValue|null $fixed
     * @param \SimpleSAML\XML\Type\BooleanValue|null $nillable
     * @param \SimpleSAML\XSD\Type\BlockSetValue|null $block
     * @param \SimpleSAML\XSD\Type\FormChoiceValue|null $form
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?NCNameValue $name = null,
        ?QNameValue $reference = null,
        LocalSimpleType|LocalComplexType|null $localType = null,
        array $identityConstraint = [],
        ?QNameValue $type = null,
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
        ?StringValue $default = null,
        ?StringValue $fixed = null,
        ?BooleanValue $nillable = null,
        ?BlockSetValue $block = null,
        ?FormChoiceValue $form = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            name: $name,
            reference: $reference,
            localType: $localType,
            identityConstraint: $identityConstraint,
            type: $type,
            minOccurs: $minOccurs,
            maxOccurs: $maxOccurs,
            default: $default,
            fixed: $fixed,
            nillable: $nillable,
            block: $block,
            form: $form,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
