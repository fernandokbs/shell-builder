<?php

use Fernandokbs\ShellBuilder\Shell;

it('can add flag', function () {
    $command = Shell::create('ruby')
        ->withFlag('-v')
        ->getExecuteCommand();

    expect($command)->toBe('ruby -v');
});

it('can add multiple flags', function () {
    $command = Shell::create('ls')
        ->withFlags(['-l', '-a'])
        ->getExecuteCommand();

    expect($command)->toBe('ls -l -a');
});

it('can add option', function () {
    $command = Shell::create('ruby')
        ->withFlag('-v')
        ->withOption('-e', 'puts "Hello World"')
        ->getExecuteCommand();

    expect($command)->toBe('ruby -v -e puts "Hello World"');
});

it('can add multiple options', function () {
    $command = Shell::create('gpg')
        ->withOptions([
            '--recipient' => 'fernando93d@gmail.com',
            '--sign' => './doc.txt',
        ])
        ->getExecuteCommand();

    expect($command)->toBe('gpg --recipient fernando93d@gmail.com --sign ./doc.txt');
});

it('can add argument', function () {
    $command = Shell::create('diff')
        ->withArgument('./file1.txt')
        ->getExecuteCommand();

    expect($command)->toBe('diff ./file1.txt');
});

it('can add multiple arguments', function () {
    $command = Shell::create('diff')
        ->withArguments(['./file1.txt', './file2.txt'])
        ->getExecuteCommand();

    expect($command)->toBe('diff ./file1.txt ./file2.txt');
});

it('can add environment variable', function () {
    $command = Shell::create('php')
        ->withEnvironmentVariable('APP_ENV', 'testing')
        ->getExecuteCommand();

    expect($command)->toBe('APP_ENV=testing php');
});

it('can add multiple environment variables', function () {
    $command = Shell::create('php')
        ->withEnvironmentVariables([
            'APP_ENV' => 'testing',
            'APP_DEBUG' => 'true',
        ])
        ->getExecuteCommand();

    expect($command)->toBe('APP_ENV=testing APP_DEBUG=true php');
});

it('can add sub command', function () {
    $command = Shell::create('git')
        ->withFlag('--no-pager')
        ->withSubCommand('log')
        ->getExecuteCommand();

    expect($command)->toBe('git --no-pager log');
});

it('can add sub command with arguments', function () {
    $command = Shell::create('git')
        ->withFlag('--no-pager')
        ->withSubCommand('log', function ($builder) {
            $builder->withFlag('--oneline');
        })
        ->getExecuteCommand();

    expect($command)->toBe('git --no-pager log --oneline');
});

it('can execute command', function () {
    $command = Shell::create('php')
        ->withFlag('-v')
        ->execute();

    expect($command->getExitCode())->toBe(0);
});
