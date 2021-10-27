MiniYAML
========

[![Build Status](https://app.travis-ci.com/atk14/MiniYaml.svg?branch=master)](https://app.travis-ci.com/atk14/MiniYaml)

MiniYAML is a YAML dumper & loader.

Usage
-----

    $ary = miniYAML::Load($yaml_str);
    $yaml = miniYAML::Dump($ary);


Installation
------------

Use the Composer:

    composer require atk14/mini-yaml

Testing
-------

    composer update --dev
    cd test
    ../vendor/bin/run_unit_tests

License
-------

MiniYAML is free software distributed [under the terms of the MIT license](http://www.opensource.org/licenses/mit-license)

[//]: # ( vim: set ts=2 et: )
