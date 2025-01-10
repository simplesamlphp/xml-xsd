<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;

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
     * @var string
     */
    protected string $name;


    /**
     * The reference.
     *
     * @var string
     */
    protected string $reference;


    /**
     * Collect the value of the name-property
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Set the value of the name-property
     *
     * @param string $name
     */
    protected function setName(string $name): void
    {
        Assert::validNCName($name, SchemaViolationException::class);

        $this->name = $name;
    }


    /**
     * Collect the value of the reference-property
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }


    /**
     * Set the value of the reference-property
     *
     * @param string $reference
     */
    protected function setReference(string $reference): void
    {
        Assert::validQName($reference, SchemaViolationException::class);

        $this->reference = $reference;
    }
}
