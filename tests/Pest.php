<?php

use Fernandokbs\ShellBuilder\ShellBuilderClass;

it('can add flag', function () {
    $command = ShellBuilderClass::create("ruby")
                    ->withFlag("-v")
                    ->getExecuteCommand();

    expect($command)->toBe("ruby -v");
});

it('can add multiple flags', function () {
    $command = ShellBuilderClass::create("ls")
                    ->withFlag("-l")
                    ->withFlag("-a")
                    ->getExecuteCommand();

    expect($command)->toBe("ls -l -a");
});

it('can add option', function () {
    $command = ShellBuilderClass::create("ruby")
                    ->withFlag("-v")
                    ->withOption('-e', 'puts "Hello World"')
                    ->getExecuteCommand();

    expect($command)->toBe('ruby -v -e puts "Hello World"');
});