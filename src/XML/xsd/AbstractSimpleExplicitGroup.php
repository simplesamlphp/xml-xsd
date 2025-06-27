<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\IDValue;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class representing the simpleExplicitGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractSimpleExplicitGroup extends AbstractExplicitGroup
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Group constructor
     *
     * @param array<\SimpleSAML\XSD\XML\xsd\NestedParticleInterface> $nestedParticles
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        array $nestedParticles = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            nestedParticles: $nestedParticles,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
