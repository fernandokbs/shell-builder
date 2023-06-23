<?php

use Fernandokbs\ShellBuilder\ShellBuilderClass;

it('can add flag', function () {
    $command = ShellBuilderClass::create('ruby')
        ->withFlag('-v')
        ->getExecuteCommand();

    expect($command)->toBe('ruby -v');
});

it('can add multiple flags', function () {
    $command = ShellBuilderClass::create("ls")
                    ->withFlags(['-l', '-a'])
                    ->getExecuteCommand();

    expect($command)->toBe('ls -l -a');
});

it('can add option', function () {
    $command = ShellBuilderClass::create('ruby')
        ->withFlag('-v')
        ->withOption('-e', 'puts "Hello World"')
        ->getExecuteCommand();

    expect($command)->toBe('ruby -v -e puts "Hello World"');
});

it('can add multiple options', function () {
    $command = ShellBuilderClass::create("gpg")
                    ->withOptions([
                        '--recipient' => 'fernando93d@gmail.com',
                        '--sign' => './doc.txt'
                    ])
                    ->getExecuteCommand();

    expect($command)->toBe('gpg --recipient fernando93d@gmail.com --sign ./doc.txt');
});

it('can add argument', function () {
    $command = ShellBuilderClass::create("diff")
                    ->withArgument('./file1.txt')
                    ->getExecuteCommand();

    expect($command)->toBe('diff ./file1.txt');
});

it('can add multiple arguments', function () {
    $command = ShellBuilderClass::create("diff")
                    ->withArguments(['./file1.txt', './file2.txt'])
                    ->getExecuteCommand();

    expect($command)->toBe('diff ./file1.txt ./file2.txt');
});

it('can add environment variable', function () {
    $command = ShellBuilderClass::create("php")
                    ->withEnvironmentVariable('APP_ENV', 'testing')
                    ->getExecuteCommand();

    expect($command)->toBe('APP_ENV=testing php');
});

it('can add multiple environment variables', function () {
    $command = ShellBuilderClass::create("php")
                    ->withEnvironmentVariables([
                        'APP_ENV' => 'testing',
                        'APP_DEBUG' => 'true'
                    ])
                    ->getExecuteCommand();

    expect($command)->toBe('APP_ENV=testing APP_DEBUG=true php');
});

it('can add sub command', function () {
    $command = ShellBuilderClass::create("git")
                    ->withFlag('--no-pager')
                    ->withSubCommand('log')
                    ->getExecuteCommand();

    expect($command)->toBe('git --no-pager log');
});

it('can add sub command with arguments', function () {
    $command = ShellBuilderClass::create("git")
                    ->withFlag('--no-pager')
                    ->withSubCommand('log', function ($builder) {
                        $builder->withFlag('--oneline');
                    })
                    ->getExecuteCommand();

    expect($command)->toBe('git --no-pager log --oneline');
});
