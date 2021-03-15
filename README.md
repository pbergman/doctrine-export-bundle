## Export bundle

And bundle for exporting query results to different output types. This can be done by defining a query in the config or using the raw command directly. 

### Installing

```composer require pbergman\doctrine-export-bundle```

### Usage

Configure a query:

```
p_bergman_doctrine_export:
  example:
      description: An example command
      query: |
        select 1,2,3

```

with the list command you can print a overview of all commands:

```
php bin/console pbergman:export:list
 ----------- ---------------------------------------------------------------------------------- 
  name                                   description                                                                       
 ----------- ---------------------------------------------------------------------------------- 
  example     An example command  
 ----------- ---------------------------------------------------------------------------------- 
```

and execute the command:

```
php bin/console pbergman:export:exec -F json
[{"1":"1","2":"2","3":"3"}]
```

or do a raw export:

```
php bin/console pbergman:export:raw -F json 'select 1,2,3'
[{"1":"1","2":"2","3":"3"}]
```
