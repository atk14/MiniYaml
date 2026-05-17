<?php
class TcMultirowsScalars extends TcBase {

	function test_load(){
		$src = '
---
key: |
  line 1
  line 2
		';
		$value = miniYAML::Load($src);
		$this->assertEquals(["key" => "line 1\nline 2"],$value);

		$src = '
---
key: >
  line 1
  line 2
		';
		$value = miniYAML::Load($src);
		$this->assertEquals(["key" => "line 1 line 2"],$value);
	}

	function test_dump(){
		$this->assertEquals(trim('
---
key: |
  line 1
  line 2
		'),trim(miniYAML::Dump([
			"key" => "line 1\nline 2",
		])));
	}

	function test_in_the_middle_of_hash(){
		// Literal block scalar between other keys
		$src = '
---
key1: value1
key2: |
  line 1
  line 2
key3: value3
		';
		$ar = miniYAML::Load($src);
		$this->assertEquals([
			"key1" => "value1",
			"key2" => "line 1\nline 2",
			"key3" => "value3",
		],$ar);

		// Folded block scalar between other keys
		$src = '
---
key1: value1
key2: >
  line 1
  line 2
key3: value3
		';
		$ar = miniYAML::Load($src);
		$this->assertEquals([
			"key1" => "value1",
			"key2" => "line 1 line 2",
			"key3" => "value3",
		],$ar);
	}

	function test_roundtrip(){
		$original = [
			"key1" => "value1",
			"key2" => "line 1\nline 2",
			"key3" => "value3",
		];
		$this->assertEquals($original,miniYAML::Load(miniYAML::Dump($original)));
	}
}
