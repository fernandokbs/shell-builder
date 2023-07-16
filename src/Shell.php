<?php

namespace Fernandokbs\ShellBuilder;

use Closure;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Shell
{
    protected string $binary;

    protected array $flags = [];

    protected array $options = [];

    protected array $arguments = [];

    protected array $environmentVariables = [];

    public function __construct($binary = 'php')
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

    public function withFlags(array $flags): self
    {
        foreach ($flags as $flag) {
            $this->withFlag($flag);
        }

        return $this;
    }

    public function withOption(string $option, string $value): self
    {
        $this->options[] = "{$option} {$value}";

        return $this;
    }

    public function withOptions(array $options): self
    {
        foreach ($options as $option => $value) {
            $this->withOption($option, $value);
        }

        return $this;
    }

    public function withArgument(string $argument): self
    {
        $this->arguments[] = $argument;

        return $this;
    }

    public function withArguments(array $arguments): self
    {
        foreach ($arguments as $argument) {
            $this->withArgument($argument);
        }

        return $this;
    }

    public function withEnvironmentVariable(string $variable, string $value): self
    {
        $this->environmentVariables[] = "{$variable}={$value}";

        return $this;
    }

    public function withEnvironmentVariables(array $variables): self
    {
        foreach ($variables as $variable => $value) {
            $this->withEnvironmentVariable($variable, $value);
        }

        return $this;
    }

    public function withSubCommand($command, Closure $callback = null): self
    {
        $builder = static::create($command);

        if ($callback) {
            $callback($builder);
        }

        $this->options[] = $builder->getExecuteCommand();

        return $this;
    }

    public function getExecuteCommand(): string
    {
        $command = "{$this->binary}";

        $flags = implode(' ', $this->flags);
        $options = implode(' ', $this->options);
        $arguments = implode(' ', $this->arguments);
        $environmentVariables = implode(' ', $this->environmentVariables);

        if ($environmentVariables) {
            $command = "{$environmentVariables} {$command}";
        }

        if ($flags) {
            $command .= " {$flags}";
        }

        if ($options) {
            $command .= " {$options}";
        }

        if ($arguments) {
            $command .= " {$arguments}";
        }

        return $command;
    }

    public function execute(): Process
    {
        $process = Process::fromShellCommandline($this->getExecuteCommand());

        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process;
    }
}
