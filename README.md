# Shell builder

Command line builder utilities.

## Usage

```php
use Fernandokbs\ShellBuilder\ShellBuilder;

ShellBuilder::create('ruby')
    ->withFlag('-v')
    ->getExecuteCommand();

# output = ruby -v
```

#### Flags

```php
ShellBuilder::create('ls')
    ->withFlags(['-l', '-a'])
    ->getExecuteCommand();

# output = ls -l -a
```

### Options

```php
ShellBuilder::create('ruby')
        ->withFlag('-v')
        ->withOption('-e', 'puts "Hello World"')
        ->getExecuteCommand();

# output = ruby -v -e puts "Hello"
```

or `#withOptions`, either as a array:

```php
ShellBuilder::create('gpg')
    ->withOptions([
        '--recipient' => 'fernando93d@gmail.com',
        '--sign' => './doc.txt',
    ])
    ->getExecuteCommand();

# output = gpg --recipient tobyclemson@gmail.com --sign ./doc.txt
```

### Arguments

```php
ShellBuilder::create('diff')
    ->withArgument('./file1.txt')
    ->getExecuteCommand();

# output = diff ./file1.txt
```

or `#withArguments`, either as a array:

```php
ShellBuilder::create('diff')
    ->withArguments(['./file1.txt', './file2.txt'])
    ->getExecuteCommand();

# output = diff ./file1.txt ./file2.txt

```

### Subcommands

Subcommands can be added using `withSubcommand`

```php

ShellBuilder::create('git')
    ->withFlag('--no-pager')
    ->withSubCommand('log')
    ->getExecuteCommand();

# => git --no-pager log
```

Subcommands also support options via `withFlag`, `withFlags`, `withOption`, `withOptions`, via a closure:

```php

ShellBuilder::create('git')
    ->withFlag('--no-pager')
    ->withSubCommand('log', function ($builder) {
        $builder->withFlag('--oneline');
    })
    ->getExecuteCommand();

# => git --no-pager log --oneline
```
