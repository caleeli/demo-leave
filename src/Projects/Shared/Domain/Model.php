<?php

namespace ProcessMaker\Package\DemoLeave\Projects\Shared\Domain;

use JsonSerializable;

/**
 * Base for demo-leave domain entities serialized in process data.
 */
abstract class Model implements JsonSerializable
{
    /**
     * @param array<string, mixed> $properties
     */
    public function __construct(protected array $properties = [])
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->properties;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->properties;
    }
}
