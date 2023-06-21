<?php

namespace Fernandokbs\ShellBuilder;

class ShellBuilderClass
{
    protected string $binary;

    protected array $flags = [];

    protected array $options = [];

    public function __construct($binary = 'bash')
    {
        $this->binary = $binary;
    }

    public static function create(...$args): self
    {
        return new static(...$args);
    }

    public function withFlag(string $flag): self
    {
        $this->flags[] = $flag;

        return $this;
    }

    public function withOption(string $option, string $value): self
    {
        $this->options[] = "{$option} {$value}";

        return $this;
    }

    public function getExecuteCommand(): string
    {
        $flags = implode(' ', $this->getFlags());

        $options = implode(' ', $this->options);

        return trim("{$this->binary} {$flags} {$options}");
    }

    protected function getFlags(): array
    {
        return array_values($this->flags);
    }
}
