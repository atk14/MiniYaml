MiniYAML
========

[![Tests](https://github.com/atk14/MiniYaml/actions/workflows/tests.yml/badge.svg)](https://github.com/atk14/MiniYaml/actions/workflows/tests.yml)

MiniYAML is a minimalistic YAML loader and dumper for PHP. It handles the subset of YAML commonly used for configuration files and API responses.

Installation
------------

    composer require atk14/mini-yaml

Usage
-----

### Load

```php
$ar = miniYAML::Load($yaml_string);
```

Options:

| Option | Type | Default | Description |
|---|---|---|---|
| `nullable` | bool | `true` | Treat `null` and `NULL` as PHP `null` |
| `interpret_php` | bool | `false` | Evaluate PHP tags (`<?php ... ?>`) embedded in the YAML string |
| `values` | array | `[]` | Variables made available when `interpret_php` is enabled |

```php
// Disable null handling — "null" is kept as a plain string
$ar = miniYAML::Load($yaml_string, ["nullable" => false]);

// Evaluate embedded PHP
$yaml = miniYAML::Load($template, [
    "interpret_php" => true,
    "values" => ["domain" => "example.com"],
]);
```

### Dump

```php
$yaml = miniYAML::Dump($array);
```

Options:

| Option | Type | Default | Description |
|---|---|---|---|
| `nullable` | bool | `true` | Dump PHP `null` as `NULL`; when `false`, dumps as empty string `""` |

```php
$yaml = miniYAML::Dump($array, ["nullable" => false]);
```

Supported YAML features
-----------------------

**Load and Dump:**
- Hash (associative) arrays: `key: value`
- Indexed (list) arrays: `- item`
- Nested structures of arbitrary depth
- Empty arrays: `[]`
- Quoted strings: `"value"` and `'value'`
- `null` / `NULL` values (controlled by the `nullable` option)
- Comments: lines starting with `#`

**Load only:**
- Literal block scalars (`|`) — newlines preserved
- Folded block scalars (`>`) — newlines replaced with spaces

**Dump only:**
- Strings containing newlines are automatically serialized as literal block scalars (`|`)
- Strings requiring escaping (colons, special characters, YAML keywords, …) are wrapped in double quotes

Example
-------

```php
$yaml = '
---
status: success
message: Ok
data:
  domain: example.com
  admin:
  - Alice
  - Bob
  description: |
    First line.
    Second line.
';

$ar = miniYAML::Load($yaml);
// [
//   "status"  => "success",
//   "message" => "Ok",
//   "data"    => [
//     "domain"      => "example.com",
//     "admin"       => ["Alice", "Bob"],
//     "description" => "First line.\nSecond line.",
//   ]
// ]

echo miniYAML::Dump($ar);
```

Limitations
-----------

The following YAML features are **not** supported:

- Multiline plain scalars (without `|` or `>`)
- Anchors and aliases (`&`, `*`)
- Explicit type tags (`!!str`, `!!int`, …)
- Flow mappings and sequences (`{…}`, `[…]`) — except empty array `[]`
- Documents with a common base indentation on all lines

Testing
-------

    composer update --dev
    ./vendor/bin/run_unit_tests test

License
-------

MiniYAML is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )
