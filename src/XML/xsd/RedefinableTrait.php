<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that are part of the xs:redefinable group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait RedefinableTrait
{
    /**
     * The redefinable.
     *
     * @var \SimpleSAML\XSD\XML\xsd\RedefinableInterface|null
     */
    protected ?RedefinableInterface $redefinable = null;


    /**
     * Collect the value of the redefinable-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\RedefinableInterface|null
     */
    public function getRedefinable(): ?RedefinableInterface
    {
        return $this->redefinable;
    }


    /**
     * Set the value of the redefinable-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\RedefinableInterface|null $redefinable
     */
    protected function setRedefinable(?RedefinableInterface $redefinable = null): void
    {
        $this->redefinable = $redefinable;
    }
}
