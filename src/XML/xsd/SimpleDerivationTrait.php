<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that can occur in the xs:simpleDerivation group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait SimpleDerivationTrait
{
    /**
     * The derivation.
     *
     * @var \SimpleSAML\XSD\XML\xsd\SimpleDerivationInterface
     */
    protected SimpleDerivationInterface $derivation;


    /**
     * Collect the value of the derivation-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\SimpleDerivationInterface
     */
    public function getDerivation(): SimpleDerivationInterface
    {
        return $this->derivation;
    }


    /**
     * Set the value of the derivation-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\SimpleDerivationInterface $derivation
     */
    protected function setDerivation(SimpleDerivationInterface $derivation): void
    {
        $this->derivation = $derivation;
    }
}
