<?php
/**
 * User: juanda
 * Date: 25/09/13
 * Time: 11:10
 */

namespace Jazzyweb\Bookmaker\Book;


class Book implements \Serializable{

    private $source;
    private $output;

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    /**
     * @return mixed
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param mixed $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }


    public function serialize()
    {
        return serialize(array(
            'source' => $this->source,
            'output' => $this->output,
        ));
    }

    public function unserialize($data)
    {
        $data = unserialize($data);
        $this->source = $data['source'];
        $this->output = $data['output'];
    }
}