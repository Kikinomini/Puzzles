<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 22.06.2015
 * Time: 19:14
 */

namespace Application\Model;


class FileMaker
{
    private $fileString;
    private $tabIndex;

    private $tab = "    ";
    private $eolChar = PHP_EOL;

    public function __construct()
    {
        $this->fileString = "";
        $this->tabIndex = 0;
    }

    /**
     * @return mixed
     */
    public function getFileString()
    {
        return $this->fileString;
    }

    /**
     * @param mixed $fileString
     */
    public function setFileString($fileString)
    {
        $this->fileString = $fileString;
    }

    /**
     * @return mixed
     */
    public function getTabIndex()
    {
        return $this->tabIndex;
    }

    /**
     * @param mixed $tabIndex
     */
    public function setTabIndex($tabIndex)
    {

        if ($tabIndex < 0) {
            $tabIndex = 0;
        }
        $this->tabIndex = $tabIndex;

    }

    public function incrementTab()
    {
        $this->setTabIndex($this->tabIndex + 1);
        return $this;
    }

    public function decrementTab()
    {
        $this->setTabIndex($this->tabIndex - 1);
        return $this;
    }

    public function addLine($line, $indent = true)
    {
        $tabs = "";
        if ($indent == true)
        {
            for ($i = 0; $i < $this->tabIndex; $i++)
            {
                $tabs .= $this->tab;
            }
        }
        $this->fileString .= $tabs.$line.$this->eolChar;
        return $this;
    }
    public function addBlankLine()
    {
        $this->addLine("", false);
        return $this;
    }
} 