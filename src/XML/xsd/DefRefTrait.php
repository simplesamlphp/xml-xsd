<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Type\{NCNameValue, QNameValue};

/**
 * Trait grouping common functionality for elements that use the defRef-attributeGroup.
 *
 * @package simplesamlphp/xml-xsd
 */
trait DefRefTrait
{
    /**
     * The name.
     *
     * @var \SimpleSAML\XML\Type\NCNameValue|null
     */
    protected ?NCNameValue $name = null;


    /**
     * The reference.
     *
     * @var \SimpleSAML\XML\Type\QNameValue|null
     */
    protected ?QNameValue $reference = null;


    /**
     * Collect the value of the name-property
     *
     * @return \SimpleSAML\XML\Type\NCNameValue|null
     */
    public function getName(): ?NCNameValue
    {
        return $this->name;
    }


    /**
     * Set the value of the name-property
     *
     * @param \SimpleSAML\XML\Type\NCNameValue|null $name
     */
    protected function setName(?NCNameValue $name): void
    {
        $this->name = $name;
    }


    /**
     * Collect the value of the reference-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue|null
     */
    public function getReference(): ?QNameValue
    {
        return $this->reference;
    }


    /**
     * Set the value of the reference-property
     *
     * @param \SimpleSAML\XML\Type\QNameValue|null $reference
     */
    protected function setReference(?QNameValue $reference): void
    {
        $this->reference = $reference;
    }
}
