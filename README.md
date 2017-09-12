# Phing task
```xml
<?xml version="1.0" ?>

<project name="test" basedir=".">
    <taskdef name="backtrac-compare" classname="\EC\Utils\Backtrac\BacktracCompareTask" />
    <taskdef name="backtrac-set-url" classname="\EC\Utils\Backtrac\BackTracSetUrlTask" />

    <target name="backtrac-test">
      <backtrac-set-url environment="dev" url="http://xyz.com" auth_token="xxxxxxxx" />
      <backtrack-compare compare_mode="compare_prod_dev" return_result="true" /> 
    </target>
</project>
```