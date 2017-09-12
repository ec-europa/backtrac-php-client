# Backtrac PHP client

This projects includes both a client library and a phing helper to trigger visual comparaison.

## Installation

```sh
composer require ec-europa/backtrac-php-client
```

## Usage as library

See [example.php](tests/example.php)

## Usage as Phing task
```xml
<?xml version="1.0" ?>

<project default="backtrac-test" name="test" basedir=".">
    <autoloader autoloaderpath="${project.basedir}/vendor/autoload.php"/>
    <taskdef name="backtrac-compare" classname="BacktracTasks\BacktracCompareTask" />
    <taskdef name="backtrac-set-url" classname="BacktracTasks\BacktracSetUrlTask" />

    <target name="backtrac-test">
        <backtrac-set-url environment="dev" url="http://xyz.com" project_id="12" auth_token="xxxxxxxx" />
        <backtrack-compare compare_mode="compare_prod_dev" project_id="12" auth_token="xxxxxxxx" />
    </target>
</project>
```