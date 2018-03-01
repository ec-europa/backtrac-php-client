# Backtrac PHP client

This projects includes both a client library and a phing helper to trigger visual comparison.

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
        <backtrac-set-url environment="development" url="http://xyz.com" project_id="12" auth_token="xxxxxxxx" />
        <backtrac-compare compare_mode="compare_prod_dev" project_id="12" check_results="true" auth_token="xxxxxxxx" />
    </target>
    
    <!-- Example target for comparing environment to latest snapshot. -->
    <target name="backtrac-test">
        <backtrac-compare compare_mode="compare_itself" environment="production" project_id="12" check_results="true" auth_token="xxxxxxxx" />
    </target>
</project>
```