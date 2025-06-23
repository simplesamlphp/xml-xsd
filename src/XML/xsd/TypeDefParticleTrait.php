<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

/**
 * Trait grouping common functionality for elements that are part of the xs:typeDefParticle group.
 *
 * @package simplesamlphp/xml-xsd
 */
trait TypeDefParticleTrait
{
    /**
     * The particle.
     *
     * @var \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null
     */
    protected ?TypeDefParticleInterface $particle = null;


    /**
     * Collect the value of the particle-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null
     */
    public function getParticle(): ?TypeDefParticleInterface
    {
        return $this->particle;
    }


    /**
     * Set the value of the particle-property
     *
     * @param \SimpleSAML\XSD\XML\xsd\TypeDefParticleInterface|null $particle
     */
    protected function setParticle(?TypeDefParticleInterface $particle = null): void
    {
        $this->particle = $particle;
    }
}
