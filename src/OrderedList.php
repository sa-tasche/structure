<?php

namespace Shadowhand\Destrukt;

class OrderedList implements StructInterface
{
    use Storage;

    /**
     * @var callable
     */
    private $sorter = 'sort';

    public function validate(array $data)
    {
        if (array_values($data) !== $data) {
            throw new \InvalidArgumentException(
                'List structures cannot be indexed by keys'
            );
        }
    }

    public function getData()
    {
        // Hack to work around call_user_func being unable to pass by reference.
        // This is the offically recommended solution from http://php.net/call_user_func
        call_user_func_array($this->sorter, array(&$this->data));

        return $this->data;
    }

    /**
     * Get a copy with a different sorting method.
     *
     * @param  callable $sorter
     * @return self
     */
    public function withSorter(callable $sorter)
    {
        $copy = clone $this;
        $copy->sorter = $sorter;

        return $copy;
    }

    /**
     * Get a copy with an new value.
     *
     * @param  mixed $value
     * @return self
     */
    public function withValue($value)
    {
        $copy = clone $this;
        $copy->data[] = $value;

        return $copy;
    }
}