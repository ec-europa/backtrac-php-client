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
    <!-- Import the phing tasks into your project. -->
    <import file="${project.basedir}/vendor/ec-europa/backtrac-php-client/phing/import.xml" />
    
    <!-- Example target for comparing prod and dev. -->
    <target name="backtrac-test">
        <backtrac-set-url environment="dev" url="http://xyz.com" project_id="12" auth_token="xxxxxxxx" />
        <backtrack-compare compare_mode="compare_prod_dev" project_id="12" auth_token="xxxxxxxx" />
    </target>
</project>
```