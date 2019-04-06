<?php

namespace App\Http\Controllers\Utility;

use Illuminate\Support\Facades\Storage;

class CsvController
{
    /**
     * The converted array.
     *
     * @var array
     */
    private $collection;

    /**
     * Filename.
     *
     * @var string
     */
    private $file;

    /**
     * Data rows of the file.
     *
     * @var array
     */
    private $data;

    /**
     * Get converted csv file into array.
     *
     * @param string $file
     * @param mixed $properties
     * @return array
     */
    public static function importToArray(string $file, $properties = false) : array
    {
        $model = new self();
        $model->file = $file;
        $model->setCollection($properties);
        return $model->collection;
    }

    /**
     * Set collection.
     *
     * @param mixed $properties
     * @return void
     */
    private function setCollection($properties)
    {
        $file = Storage::get($this->file);
        $this->data = explode ( "\r\n" , $file);
        $this->collection = $properties === false ? $this->getArrayWithoutProperties() : $this->getArrayWithProperties($properties);
    }

    /**
     * Get converted array without preset properties .
     *
     * @return array
     */
    private function getArrayWithoutProperties() : array
    {
        $properties = explode ( "," , array_shift ($this->data));
        $properties = $this->getCorrectProperties($properties);
        return $this->getArrayWithProperties($properties);
    }

    /**
     * Get converted array with preset properties.
     *
     * @param array $properties
     * @return array
     */
    private function getArrayWithProperties(array $properties) : array
    {
        $collection = [];
        foreach ($this->data as $row)
        {
            $cells = explode ( "," , $row);
            $fillableRow = [];
            foreach ($cells as $k => $cell)
            {
                $fillableRow[$properties[$k]] = $cell;
            }
            array_push($collection, $fillableRow);
        }
        return $collection;
    }

    /**
     * Get lower case properties without spaces.
     *
     * @param array $properties
     * @return array
     */
    private function getCorrectProperties(array $properties) : array
    {
        foreach ($properties as $k => $property)
        {
            $properties[$k] = $this->getCorrectProperty($property);
        }
        return $properties;
    }

    /**
     * Get lower case property without spaces.
     *
     * @param string $property
     * @return string
     */
    private function getCorrectProperty(string $property) : string
    {
        $property = str_replace ( ' ' , '_' , $property);
        return strtolower($property);
    }
}
