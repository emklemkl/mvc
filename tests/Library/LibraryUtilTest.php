<?php

namespace App\Library;

use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class LibraryUtil
 */
class LibraryUtilTest extends TestCase
{
    public function testLibraryUtil()
    {
        $util = new LibraryUtil();
        $this->assertInstanceOf("\App\Library\LibraryUtil", $util);
    }
    
    public function testBookExistRaiseException()
    {
        $util = new LibraryUtil();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("No book found on this id/isbn");
        $util->bookExists([]);
    }
}
