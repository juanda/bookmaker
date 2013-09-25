<?php
/**
 * User: juanda
 * Date: 25/09/13
 * Time: 11:12
 */

namespace Jazzyweb\Bookmaker\Book;

use Traversable;

class BookCollection implements \IteratorAggregate, \Countable{

    private $bookcollection;

    public function __construct(){
        $this->bookcollection = array();
    }

    /**
     * Add a book
     *
     * @param string $name The name of the book
     * @param Book $book   A Book instance
     *
     */
    public function add($name, Book $book){

        unset($this->bookcollection[$name]);

        $this->bookcollection[$name] = $book;
    }

    /**
     * Gets the book named $name
     *
     * @param $name
     * @return null
     */
    public function get($name){
        return isset($this->bookcollection[$name]) ? $this->bookcollection[$name] : null;
    }

    /**
     * Removes a book
     *
     * @param string $name the book name to remove
     */
    public function remove($name){
        unset($this->bookcollection[$name]);
    }

    public function getBookNames(){

        $names = array();
        foreach($this->bookcollection as $name => $book){
            $names[] = $name;
        }

        return $names;
    }

    /**
     * * Gets the current BookCollection as an Iterator that includes all books.
     *
     * It implements \IteratorAggregate.
     *
     * @see all()
     *
     * @return \ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->bookcollection);
    }

    /**
     * * Gets the number of Books in this collection
     * @return int
     */
    public function count()
    {
        return count($this->bookcollection);
    }
}