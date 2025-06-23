<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{IDValue, NCNameValue};

/**
 * Abstract class representing the abstract localSimpleType.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractLocalSimpleType extends AbstractSimpleType
{
    /**
     * Annotated constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\SimpleDerivationInterface $derivation
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        SimpleDerivationInterface $derivation,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct(
            derivation: $derivation,
            annotation: $annotation,
            id: $id,
            namespacedAttributes: $namespacedAttributes,
        );
    }
}
