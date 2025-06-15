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
     * @var \SimpleSAML\XSD\XML\xsd\Restriction|\SimpleSAML\XSD\XML\xsd\XsList|\SimpleSAML\XSD\XML\xsd\Union
     */
    protected Restriction|XsList|Union $derivation;


    /**
     * Collect the value of the derivation-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\Restriction|\SimpleSAML\XSD\XML\xsd\XsList|\SimpleSAML\XSD\XML\xsd\Union
     */
    public function getDerivation(): Restriction|XsList|Union
    {
        return $this->derivation;
    }


    /**
     * Set the value of the derivation-property
     *
     * @param (
     *   \SimpleSAML\XSD\XML\xsd\Restriction|
     *   \SimpleSAML\XSD\XML\xsd\XsList|
     *   \SimpleSAML\XSD\XML\xsd\Union
     * ) $derivation
     */
    protected function setDerivation(Restriction|XsList|Union $derivation): void
    {
        $this->derivation = $derivation;
    }
}
