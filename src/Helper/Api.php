<?php

namespace TutuRu\CodeceptionTools\Helper;

use cebe\openapi\Reader;
use Codeception\Module\REST;
use TutuRu\CodeceptionTools\JsonSchema\Factory;
use JsonSchema\Validator as JsonSchemaValidator;
use PHPUnit\Util\Json;

class Api extends \Codeception\Module
{
    public function seeJSONSchemaValidByResponseName(string $responseName)
    {
        /** @var REST $module */
        $module = $this->getModule('REST');
        $actualContent = json_decode($module->response);
        $reader = Reader::readFromJsonFile(realpath($this->_getConfig('openapi_path')));

        if (!isset($reader->components->responses[$responseName])) {
            $this->fail('Не найден response '. $responseName);
        }

        $content = (array) $reader->components->responses[$responseName]->content;
        $jsonSchemaValidator = (new JsonSchemaValidator(new Factory()));
        $a = (array) $content['application/json']->schema->getSerializableData();
        echo json_encode($a);
        $jsonSchemaValidator->validate($actualContent, (array) $content['application/json']->schema->getSerializableData());
        if(!$jsonSchemaValidator->isValid()) {
            $this->fail("\n Errors: \n" . Json::prettify(json_encode($jsonSchemaValidator->getErrors())));
        }
    }
}
