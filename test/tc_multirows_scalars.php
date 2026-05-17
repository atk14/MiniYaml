<?php
class TcMultirowsScalars extends TcBase {

	function test(){
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
}
