<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\IDValue;
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class representing the explicitGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractExplicitGroup extends AbstractGroup
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Group constructor
     *
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     * @param array<\SimpleSAML\XSD\XML\xsd\NestedParticleInterface> $nestedParticles
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
        array $nestedParticles = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            particles: $nestedParticles,
            minOccurs: $minOccurs,
            maxOccurs: $maxOccurs,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
