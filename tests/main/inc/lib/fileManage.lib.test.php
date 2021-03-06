<?php
class TestFileManager extends UnitTestCase {

	public $fmanager;
	public function TestFileManager(){
		$this->UnitTestCase ('File Manager library - main/inc/lib/fileManage.lib.test.php');
	}

	public function setUp(){
		$this->fmanager = new FileManager();
	}

	public function tearDown(){
		$this->fmanager = null;
	}

	//todo public function testUpdatedbInfo
	//todo public function testCheckNameExist
	//todo public function testMyDelete
	//todo public function testRemoveDir
	//todo public function testMyRename
	//todo public function testMove
	//todo public function testCopyDirTo
	//todo public function testIndexDir
	//todo public function testIndexAndSortDir
	//todo public function testFormDirList
	//todo public function testMkpath
	//todo public function testGetextension
	//todo public function testDirsize
	//todo public function testListAllDirectories
	//todo public function testListAllFiles
	//todo public function testCompatLoadFile
	//todo public function testSetDefaultSettings
	//todo public function testMkdirs

	public function testUpdatedbInfo(){
		$action ='';
		$oldPath ='';
		$res = DocumentManager::updateDbInfo($action, $oldPath, $newPath="");
		$this->assertNull($res);
		//var_dump($res);
	}

	public function testCheckNameExist(){
		$filePath ='';
		$res = check_name_exist($filePath);
		$this->assertFalse($res);
		$this->assertTrue(is_bool($res));
		$this->assertTrue($res === false);
		//var_dump($res);
	}

	public function testMyDelete(){
		$file='';
		$res = my_delete($file);
		$this->assertFalse($res);
		$this->assertTrue(is_bool($res));
		$this->assertTrue($res===false);
		//var_dump($res);
	}

	public function testRemoveDir(){
		$dir='';
		$res = removeDir($dir);
		$this->assertTrue(is_bool($res));
		$this->assertFalse($res === true);
		//var_dump($res);
	}

	public function testMyRename(){
		$filePath ='document/';
		$newFileName='';
		$res = my_rename($filePath, $newFileName);
		$this->assertTrue(is_bool($res));
		$this->assertTrue($res === false);
		//var_dump($res);
	}

	public function testMove(){
		$source ='';
		$target ='';
		$res = move($source, $target);
		$this->assertTrue(is_bool($res));
		$this->assertTrue($res === false);
		$this->assertFalse($res);
		//var_dump($res);
	}

	public function testCopyDirTo(){
		$origDirPath=api_get_path(SYS_COURSE_PATH).'document/audio';
		$destination=api_get_path(SYS_COURSE_PATH).'document/flash/audio';
		$res = copyDirTo($origDirPath, $destination, $move = false);
		$this->assertTrue($res===null);
		$this->assertNull($res);
	}

	public function testFormDirList(){
		$sourceType = '';
		$sourceComponent = '';
		$command = '';
		$baseWorkDir = api_get_path(SYS_COURSE_PATH).'document/';
		$res = form_dir_list($sourceType, $sourceComponent, $command, $baseWorkDir);
		$this->assertTrue($res);
		$this->assertTrue(is_string($res));
		//var_dump($res);
	}

	public function testGetextension(){
		$filename='documents';
		$res =getextension($filename);
		$this->assertTrue($res);
		$this->assertTrue(is_array($res));
	}

	public function testDirsize(){
		$root='';
		$res =dirsize($root,$recursive=true);
		$this->assertFalse($res);
		$this->assertTrue(is_numeric($res));
		$this->assertTrue($res ===0);
		//var_dump($res);
	}
}
