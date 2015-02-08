<?php
/**
 * This file is part of PPM by simirimia
 * 
 * Date: 08.01.15
 * Time: 22:19
 */

namespace Simirimia\Ppm;


use Traversable;

use Simirimia\Ppm\Entity\Picture;


class ArrayCollection implements \Countable, \ArrayAccess, \IteratorAggregate, Collection

{
    /**
     * @var string
     */
    private $elementClassName = '';

    /**
     * @var string
     */
    private $elementIdMethod = '';

    /**
     * @var array
     */
    private $data = [];


    public function __construct( $elementClassName, $elementIdMethod )
    {
        if ( !is_string($elementClassName) ) {
            throw new \Exception( 'Class mame must be a string' );
        }
        if ( !is_string($elementIdMethod) ) {
            throw new \Exception( 'ID method mame must be a string' );
        }
        $this->elementClassName = $elementClassName;
        $this->elementIdMethod = $elementIdMethod;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        return new \ArrayIterator( $this->data );
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return Picture Can return all value types.
     */
    public function offsetGet($offset)
    {
        if ( $this->offsetExists($offset) ) {
            return $this->data[$offset];
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param Picture $value <p>
     * The value to set.
     * </p>
     * @return void
     * @throws \Exception
     */
    public function offsetSet($offset, $value)
    {
        $this->ensureElementType( $value );
        $this->data[$offset] = $value;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset( $this->data[$offset] );
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     */
    public function count()
    {
        return count($this->data);
    }


    // Custom Collection methods

    public function add( $element ) {

        $this->ensureElementType( $element );

        $this->data[$element->{$this->elementIdMethod}()] = $element;
    }

    private function ensureElementType( $element )
    {
        if ( !($element instanceof $this->elementClassName) ) {
            throw new \Exception( 'Element must be of type: ' . $this->elementClassName );
        }
        if ( !method_exists( $element, $this->elementIdMethod ) ) {
            throw new \Exception( 'Element must have public method: ' . $this->elementIdMethod );
        }
    }

}