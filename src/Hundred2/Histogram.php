<?php

namespace Linder\Hundred2;

/**
 * Generating histogram data.
 */
class Histogram
{
    /**
     * @var array $serie  The numbers stored in sequence.
     * @var int   $min    The lowest possible number.
     * @var int   $max    The highest possible number.
     */
    private $serie = [];
    private $min;
    private $max;


    /**
     * Inject the object to use as base for the histogram data.
     *
     * @param HistogramInterface $object The object holding the serie.
     *
     * @return void.
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie = $object->getHistogramSerie();
        $this->min   = $object->getHistogramMin();
        $this->max   = $object->getHistogramMax();
    }


    /**
     * Get the serie.
     *
     * @return array with the serie.
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Print out the histogram, default is to print out only the numbers
     * in the serie, but when $min and $max is set then print also empty
     * values in the serie, within the range $min, $max.
     *
     * @param int $min The lowest possible integer number.
     * @param int $max The highest possible integer number.
     *
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $result = "";
        $numbers = array_count_values($this->serie);
        if ($this->min || $this->max) {
            for ($i = $this->min; $i <= $this->max; $i++) {
                if (!array_key_exists($i, $numbers)) {
                    $numbers[$i] = 0;
                }
            }
            foreach ($numbers as $number => $amount) {
                if ($number < $this->min || $number > $this->max) {
                    unset($numbers[$number]);
                }
            }
        }
        ksort($numbers);
        foreach ($numbers as $number => $amount) {
            $result .= $number . ": " . str_repeat("*", $amount) . "<br>";
        }
        return $result;
    }
}
