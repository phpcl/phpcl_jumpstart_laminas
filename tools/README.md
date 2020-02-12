# Laminas Tools
Tools to facilitate rapid app development using Laminas

## Setup
Copy `laminas-tools*` to the `vendor/bin` folder of your ZF 3 or Laminas MVC project.

## Usage
Change to the project root directory of your ZF 3 or Laminas MVC project.

### Linux
```
vendor/bin/laminas-tools.sh WHAT PATH NAME
```

### Windows
```
vendor/bin/laminas-tools.bat WHAT PATH NAME
```

### Params
| Param | Example | Description |
| :---: | :-----: | :---------- |
| WHAT  | "module" or "controller" | Describes what component you want to build |
| PATH  | "/path/to/project" | Full path to your project root directory |
| NAME  | "Test"  | Name of the module you want to create, or |
|       | "Test\\\Controller\\\ListController" | Name of the controller you want to create |

## TODO
* Create RESTful controllers
* Create handlers in Expressive / Mezzio

