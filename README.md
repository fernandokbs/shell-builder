# Shell builder

Command line builder utilities.

## Usage

```php
use Fernandokbs\ShellBuilder\ShellBuilderClass;

ShellBuilderClass::create('ruby')
    ->withFlag('-v')
    ->getExecuteCommand();

# output = ruby -v
```

#### Flags

```php
ShellBuilderClass::create('ls')
    ->withFlags(['-l', '-a'])
    ->getExecuteCommand();

# output = ls -l -a
```

### Options

```php
ShellBuilderClass::create('ruby')
        ->withFlag('-v')
        ->withOption('-e', 'puts "Hello World"')
        ->getExecuteCommand();

# output = ruby -v -e puts "Hello"
```

or `#withOptions`, either as a array:

```php
ShellBuilderClass::create('gpg')
    ->withOptions([
        '--recipient' => 'fernando93d@gmail.com',
        '--sign' => './doc.txt',
    ])
    ->getExecuteCommand();

# output = gpg --recipient tobyclemson@gmail.com --sign ./doc.txt
```

### Arguments

```php
ShellBuilderClass::create('diff')
    ->withArgument('./file1.txt')
    ->getExecuteCommand();

# output = diff ./file1.txt
```

or `#withArguments`, either as a array:

```php
ShellBuilderClass::create('diff')
    ->withArguments(['./file1.txt', './file2.txt'])
    ->getExecuteCommand();

# output = diff ./file1.txt ./file2.txt

```

### Subcommands

Subcommands can be added using `withSubcommand`

```php

ShellBuilderClass::create('git')
    ->withFlag('--no-pager')
    ->withSubCommand('log')
    ->getExecuteCommand();

# => git --no-pager log
```

Subcommands also support options via `withFlag`, `withFlags`, `withOption`, `withOptions`, via a closure:

```php

ShellBuilderClass::create('git')
    ->withFlag('--no-pager')
    ->withSubCommand('log', function ($builder) {
        $builder->withFlag('--oneline');
    })
    ->getExecuteCommand();

# => git --no-pager log --oneline
```
