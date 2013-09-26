<?php
/**
 * This file is part of Bookmaker
 * User: juanda
 * Date: 25/09/13
 * Time: 13:16
 */

namespace Jazzyweb\Bookmaker\Tests;

use Jazzyweb\Bookmaker\Book\Book;
use Jazzyweb\Bookmaker\Book\BookCollection;

class BookCollectionTest extends \PHPUnit_Framework_TestCase {

    protected function buildBookCollection(){
        $book1 = new Book();
        $book1 -> setSource('/path/to/source1');
        $book1 -> setOutput('/path/to/output1');

        $book2 = new Book();
        $book2 -> setSource('/path/to/source2');
        $book2 -> setOutput('/path/to/output2');

        $bookCollection = new BookCollection();
        $bookCollection->add('book1', $book1);
        $bookCollection->add('book2', $book2);

        return $bookCollection;

    }

    public function testBook(){

        $book = new Book();
        $book -> setSource('/path/to/source');
        $book -> setOutput('/path/to/output');

        $bookCollection = new BookCollection();
        $bookCollection->add('test', $book);

        $this->assertEquals($book, $bookCollection->get('test'), '-> get() returns the book if it exists');
        $this->assertNull($bookCollection->get('noexist'), '-> get() returns null if the book does not exist ');
    }

    public function testBookCollectionCount(){

        $bookCollection = $this->buildBookCollection();

        $this->assertEquals(2, $bookCollection->count());
    }

    public function testBookCollectionRemove(){

        $bookCollection = $this->buildBookCollection();

        $bookCollection->remove('book2');

        $this->assertNull($bookCollection->get('book2'));
    }

    public function testBookCollectionGetBookNames(){

        $bookCollection = $this->buildBookCollection();

        $bookNames = $bookCollection->getBookNames();

        $this->assertEquals(array('book1', 'book2'), $bookNames);

    }

    public function testBookCollectionHas(){
        $bookCollection = $this->buildBookCollection();

        $this->assertEquals(true, $bookCollection->has('book1'));
        $this->assertEquals(false, $bookCollection->has('book3'));
    }
}