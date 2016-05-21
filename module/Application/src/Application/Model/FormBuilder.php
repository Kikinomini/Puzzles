<?php
/**
 * Created by PhpStorm.
 * User: Silas
 * Date: 16.06.2015
 * Time: 20:03
 */

namespace Application\Model;

class FormBuilder extends FileMaker
{
    private $elements;

    private $moduleName;
    private $entityName;
    private $formName;
    private $hydratorName;
    private $inputFilterName;

    /**
     * @return mixed
     */
    public function getHydratorName()
    {
        return $this->hydratorName;
    }

    /**
     * @param mixed $hydratorName
     */
    public function setHydratorName($hydratorName)
    {
        $this->hydratorName = $hydratorName;
    }

    /**
     * @return mixed
     */
    public function getFormName()
    {
        return $this->formName;
    }

    /**
     * @param mixed $formName
     * @param boolean $updateHydratorInputFilterName
     */
    public function setFormName($formName, $updateHydratorInputFilterName = true)
    {
        $this->formName = $formName;
        if ($updateHydratorInputFilterName == true) {
            $this->setHydratorName($this->getFormName() . "Hydrator");
            $this->setInputFilterName($this->getFormName() . "InputFilter");
        }
    }

    /**
     * @return mixed
     */
    public function getInputFilterName()
    {
        return $this->inputFilterName;
    }

    /**
     * @param mixed $inputFilterName
     */
    public function setInputFilterName($inputFilterName)
    {
        $this->inputFilterName = $inputFilterName;
    }

    public function setObject($moduleName, $entityName)
    {
        $this->moduleName = $moduleName;
        $this->entityName = $entityName;
        $this->setFormName("Modify" . $entityName . "Form");

        $this->elements = array();

        $className = $moduleName . "\\Model\\" . $entityName;
        if ($className !== false) {
            $reflectionClass = new \ReflectionClass($className);
            $reflectionProperties = $reflectionClass->getProperties();
            foreach ($reflectionProperties as $reflectionProperty) {
                $this->parseDocComments($reflectionProperty);
            }
        }
    }

    public function createForm()
    {
        $this->setFileString("");
        $this->setTabIndex(0);

        $this->addLine("<?php");
        $this->addBlankLine();
        $this->addLine("namespace " . $this->moduleName . "\\Form;");
        $this->addBlankLine();
        $this->addLine("use " . $this->moduleName . "\\Form\\Hydrator\\" . $this->getInputFilterName() . ";");
        $this->addLine("use " . $this->moduleName . "\\Form\\InputFilter\\" . $this->getInputFilterName() . ";");
        $this->addLine("use Zend\\Form\\Element\\Hidden;");
        $this->addLine("use Zend\\Form\\Element\\Submit;");
        $this->addLine("use Zend\\Form\\Element\\Text;");
        $this->addLine("use Zend\\Form\\Element\\Textarea;");
        $this->addLine("use Zend\\Form\\Element\\Select;");
        $this->addLine("use Zend\\Form\\Element\\Date;");
        $this->addLine("use Zend\\Form\\Element\\Number;");
        $this->addLine("use Zend\\Form\\Form;");
        $this->addBlankLine();
        $this->addLine("class " . $this->getFormName() . " extends Form");
        $this->addLine("{")->incrementTab();
        $this->addLine("public function __construct(\$name = null, \$options = array())"); //CONSTRUCTOR
        $this->addLine("{")->incrementTab();
        $this->addLine("parent::__construct(\$name, \$options);");
        $this->addBlankLine();
        $this->addLine("\$this->setHydrator(new " . $this->hydratorName . "());");
        $this->addLine("\$this->addElements();");
        $this->decrementTab()->addLine("}");
        $this->addBlankLine();
        $this->addElements();
        $this->decrementTab()->addLine("}");

        return $this->getFileString();
    }

    public function createHydrator()
    {
        $this->setFileString("");
        $this->setTabIndex(0);

        $this->addLine("<?php");
        $this->addBlankLine();
        $this->addLine("namespace " . $this->moduleName . "\\Form\\Hydrator;");
        $this->addBlankLine();
        $this->addLine("use " . $this->moduleName . "\\Model\\" . $this->entityName . ";");
        $this->addLine("use Zend\\Stdlib\\Hydrator\\HydratorInterface;");
        $this->addBlankLine();
        $this->addLine("class " . $this->hydratorName . " implements HydratorInterface");
        $this->addLine("{")->incrementTab();

        $this->addExtractFunction();
        $this->addBlankLine();
        $this->addHydrateFunction();

        $this->decrementTab()->addLine("}");
        return $this->getFileString();
    }

    public function createInputFilter()
    {
        $this->setFileString("");
        $this->setTabIndex(0);

        $this->addLine("<?php");
        $this->addBlankLine();
        $this->addLine("namespace " . $this->moduleName . "\\Form\\InputFilter;");
        $this->addBlankLine();
        $this->addLine("use " . $this->moduleName . "\\Model\\" . $this->entityName . ";");
        $this->addLine("use Zend\\InputFilter\\InputFilter;");
        $this->addBlankLine();
        $this->addLine("class " . $this->getInputFilterName() . " extends InputFilter");
        $this->addLine("{")->incrementTab();

        $this->addLine("public function __construct()"); //CONSTRUCTOR
        $this->addLine("{")->incrementTab();
        foreach($this->elements as $element)
        {

        }
        $this->decrementTab()->addLine("}");

        $this->decrementTab()->addLine("}");
        return $this->getFileString();
    }

    protected function addExtractFunction()
    {
        $this->addLine("/**");
        $this->addLine(" * Extract values from " . $this->entityName);
        $this->addLine(" *");
        $this->addLine(" * @param " . $this->entityName . " \$entity");
        $this->addLine(" * @return array");
        $this->addLine(" */");

        $this->addLine("public function extract(\$entity)");
        $this->addLine("{")->incrementTab();
        $this->addLine("\$data = array();");

        foreach ($this->elements as $name => $element) {
            if (isset($element["hydrators"])) {
                if (!isset($element["hydrators"]["type"])) {
                    throw new \Exception("FormBuilder: der Typ ist zwingend erforderlich! FILE: " . __FILE__ . " LINE: " . __LINE__);
                }
                switch ($element["hydrators"]["type"]) {
                    case "normal": {
                        $element["hydrators"]["arrayKey"] = (!isset($element["hydrators"]["arrayKey"])) ? $name : $element["hydrators"]["arrayKey"];
                        $element["hydrators"]["objectKey"] = (!isset($element["hydrators"]["objectKey"])) ? $name : $element["hydrators"]["objectKey"];
                        $this->addLine("\$data[\"" . $element["hydrators"]["arrayKey"] . "\"] = \$entity->get" . ucfirst($element["hydrators"]["objectKey"]) . "();");
                        break;
                    }

                    default: {
                    throw new \Exception("FormBuilder:: der Typ ist unbekannt! FILE: " . __FILE__ . " LINE: " . __LINE__);
                    }
                }
            }
        }
        $this->addBlankLine();
        $this->addLine("return \$data;");
        $this->decrementTab()->addLine("}");
    }

    protected function addHydrateFunction()
    {
        $this->addLine("/**");
        $this->addLine(" * Hydrate \$entity with the provided \$data");
        $this->addLine(" *");
        $this->addLine(" * @param array \$data");
        $this->addLine(" * @param " . $this->entityName . " \$entity");
        $this->addLine(" * @return " . $this->entityName);
        $this->addLine(" */");

        $this->addLine("public function hydrate(array \$data, \$entity)");
        $this->addLine("{")->incrementTab();

        foreach ($this->elements as $name => $element) {
            if (isset($element["hydrators"])) {
                if (!isset($element["hydrators"]["type"])) {
                    throw new \Exception("FormBuilder: der Typ ist zwingend erforderlich! FILE: " . __FILE__ . " LINE: " . __LINE__);
                }
                $element["hydrators"]["arrayKey"] = (!isset($element["hydrators"]["arrayKey"])) ? $name : $element["hydrators"]["arrayKey"];
                $element["hydrators"]["objectKey"] = (!isset($element["hydrators"]["objectKey"])) ? $name : $element["hydrators"]["objectKey"];

                switch ($element["hydrators"]["type"]) {
                    case "normal": {
                        $this->addLine("\$entity->set" . ucfirst($element["hydrators"]["objectKey"]) . "(\$data[\"" . $element["hydrators"]["arrayKey"] . "\"]);");
                        break;
                    }
                    case "entity": {
                        //TODO service Locator standardmäßig mitgeben.
                        //TODO per entityname den Manager herraussuchen
                        //TODO per ID (arrayWert) die Entity herausfinden und hinzufügen
                    }

                    default: {
                    throw new \Exception("FormBuilder:: der Typ ist unbekannt! FILE: " . __FILE__ . " LINE: " . __LINE__);
                    }
                }
            }
        }
        $this->addBlankLine();
        $this->addLine("return \$entity;");
        $this->decrementTab()->addLine("}");
    }

    protected function parseDocComments(\ReflectionProperty $property)
    {
        $docComments = $property->getDocComment();
        $needles = array('properties' => '#Form\\Element', 'validators' => '#Form\\Validator', 'hydrators' => '#Form\\Hydrator');
        foreach ($needles as $key => $needle) {
//            $this->elements[$property->getName()][$key] = array();
            $pos = strpos($docComments, $needle);
            if ($pos !== false) {
                $element = substr($docComments, $pos + strlen($needle));
                $pos = 0;
                $countPairs = 0;
                do {
                    $posTmp = strpos($element, "{", $pos);
                    $posTmp2 = strpos($element, "}", $pos);

                    if ($posTmp === false && $posTmp2 === false && $countPairs != 0) {
                        throw new \Exception("Klammersetzungsfehler bei Formularerzeugung!");
                    }

                    if ($posTmp < $posTmp2 && $posTmp !== false) {
                        $pos = $posTmp + 1;
                        $countPairs++;
                    } else {
                        $pos = $posTmp2 + 1;
                        $countPairs--;
                    }

                    if ($countPairs < 0) {
                        throw new \Exception("zu viele geschlossene Klammern bei Formularerzeugung!");
                    }
                } while ($countPairs > 0);
                $arrayString = substr($element, 0, $pos);
                $this->elements[$property->getName()][$key] = json_decode($arrayString, true);
            }
        }
    }

    protected function addElements()
    {
        $this->addLine("public function addElements()");
        $this->addLine("{")->incrementTab();
        foreach ($this->elements as $name => $element) {
            if (!isset($element["properties"]["type"])) {
                throw new \Exception("FormBuilder: der Typ ist zwingend erforderlich! FILE: " . __FILE__ . " LINE: " . __LINE__);
            }
            $classes = array("form-control");
            $element["properties"]["type"] = strtolower($element["properties"]["type"]);
            switch ($element["properties"]["type"]) {
                case "text": {
                    $this->addLine("\$" . $name . " = new Text(\"" . $name . "\");");
                    break;
                }
                case "textarea": {
                    $this->addLine("\$" . $name . " = new Textarea(\"" . $name . "\");");
                    break;
                }
                case "hidden": {
                    $this->addLine("\$" . $name . " = new Hidden(\"" . $name . "\");");
                    $classes = array();
                    break;
                }
                case "select": {
                    $this->addLine("\$" . $name . " = new Select(\"" . $name . "\");");
                    break;
                }
                case "date": {
                    $this->addLine("\$" . $name . " = new Date(\"" . $name . "\");");
                    $this->addLine("\$" . $name . "->setFormat(\"d.m.Y\");");
                    break;
                }
                case "number": {
                    $this->addLine("\$" . $name . " = new Number(\"" . $name . "\");");
                    break;
                }
                default: {
                throw new \Exception("FormBuilder:: der Typ ist unbekannt! FILE: " . __FILE__ . " LINE: " . __LINE__);
                break;
                }
            }
            $this->addLine("\$" . $name . "->setAttribute(\"id\",\"" . $name . "\");");
            foreach ($element["properties"] as $propertyName => $property) {
                switch ($propertyName) {
                    case "required": {
                        $this->addLine("\$" . $name . "->setAttribute(\"required\", \"" . (($property) ? "true" : "false") . "\");");
                        break;
                    }
                    case "datepicker": {
                        $classes[] = "datepicker";
                        break;
                    }
                    case "label": {
                        $this->addLine("\$" . $name . "->setLabel(\"" . $property . "\");");
                        break;
                    }
                }
            }
            $this->addLine("\$" . $name . "->setAttribute(\"class\", \"" . implode(" ", $classes) . "\");");
            $this->addLine("\$this->add(\$" . $name . ");");
            $this->addBlankLine();
        }

        $this->addLine("\$submitButton = new Submit(\"submitButton\");");
        $this->addLine("\$submitButton->setAttribute(\"id\",\"submitButton\");");
        $this->addLine("\$submitButton->setAttribute(\"required\",\"true\");");
        $this->addLine("\$submitButton->setAttribute(\"class\",\"form-control\");");
        $this->addLine("\$submitButton->setValue(\"Speichern\");");
        $this->addLine("\$this->add(\$submitButton);");

        $this->decrementTab()->addLine("}");
    }

}