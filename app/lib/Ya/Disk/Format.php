<?php
namespace Ya\Disk;

use Sabre\DAV\XMLUtil;
use DOMDocument as DOM;
use Sabre\DAV\Property\ResponseList;

class Format
{
    public static function getPropfind(array $properties = [])
    {
        $dom = new DOM('1.0', 'UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElementNS('DAV:', 'd:propfind');
        $prop = $dom->createElement('d:prop');

        foreach($properties as $property) {
            list($namespace, $elementName)
                = XMLUtil::parseClarkNotation($property);
            $element = ($namespace === 'DAV:')
                ? $dom->createElement('d:'.$elementName)
                : $dom->createElementNS($namespace, 'x:'.$elementName);
            $prop->appendChild($element);
        }

        $dom->appendChild($root)->appendChild($prop);

        return $dom->saveXML();
    }

    public static function parse($result, $depth = 0)
    {

        // If depth was 0, we only return the top item
        if ($depth === 0) {
            reset($result);
            $result = current($result);
            return isset($result[200])?$result[200]:[];
        }

        $newResult = [];
        foreach($result as $href => $statusList) {
            $newResult[$href] = isset($statusList[200])
                ? $statusList[200]
                : [];
        }

        return $newResult;
    }
}