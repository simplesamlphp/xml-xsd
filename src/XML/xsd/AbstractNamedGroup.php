<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{IDValue, NCNameValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

/**
 * Abstract class representing the namedGroup-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractNamedGroup extends AbstractRealGroup
{
    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;


    /**
     * Group constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\ParticleInterface $particle
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        ParticleInterface $particle,
        ?NCNameValue $name = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::nullOrIsInstanceOfAny(
            $particle,
            [All::class, Choice::class, Sequence::class],
            SchemaViolationException::class,
        );

        if ($particle instanceof All) {
            Assert::null($particle->getMinCount(), SchemaViolationException::class);
            Assert::null($particle->getMaxCount(), SchemaViolationException::class);
        }

        parent::__construct(
            name: $name,
            particle: $particle,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
