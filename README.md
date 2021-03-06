# dns-zone-configurator

[![Latest Stable Version](http://poser.pugx.org/golding/dns-zone-configurator/v)](https://packagist.org/packages/golding/dns-zone-configurator) [![Total Downloads](http://poser.pugx.org/golding/dns-zone-configurator/downloads)](https://packagist.org/packages/golding/dns-zone-configurator) [![Latest Unstable Version](http://poser.pugx.org/golding/dns-zone-configurator/v/unstable)](https://packagist.org/packages/golding/dns-zone-configurator) [![License](http://poser.pugx.org/golding/dns-zone-configurator/license)](https://packagist.org/packages/golding/dns-zone-configurator) [![PHP Version Require](http://poser.pugx.org/golding/dns-zone-configurator/require/php)](https://packagist.org/packages/golding/dns-zone-configurator)


Php library for parsing and editing dns zones files programmatically with high level abstraction.

## Installation

```shell
composer require golding/dns-zone-configurator
```

## Usage

```php
<?php
    use Golding\dns\configurator\Zone;
    
    require './vendor/autoload.php';
    
    // get you zone file content
    $content = file_get_contents(__DIR__."/dns/zones/zone.conf");
    
    // make zone object from plain content
    $zone = Zone::fromString("voksiv.ru.", $content);
    
    // iterate via nodes of zone, where Node is group of resource records with same name
    foreach ($zone->iterateNodes() as $node) {
        $node->getName();
        $node->getZone();
    }
    
    // or get concrete node
    if($zone->isNodeExist("node.name")) {
        $node = $zone->getNode("node.name");
        $node->getName();
        $node->getZone();
    }
    
    // also you can iterate via resource records in zone
    foreach ($zone->iterateRecords() as $record) {
        $record->getType();
        $record->getTtl();
        $record->getNode();
    }
    // or iterate in node
    if($zone->isNodeExist("node.name")) {
        $node = $zone->getNode("node.name");
        foreach ($node->iterateRecords() as $record) {
            $record->getType();
            $record->getTtl();
            $record->getNode();
        }
    }
    // or iterate only concrete records in zone or node
    foreach ($zone->iterateA() as $record) {
        $record->getAddress();
        $record->getType();
        $record->getTtl();
        $record->getNode();
    }
    
    // all records can be modified
    foreach ($zone->iterateNs() as $record) {
        $record->setNsdName("new.nsd.name.");
    }
    
    // or they can be deleted
    foreach ($zone->iterateMx() as $record) {
        $record->remove();
    }
    
    // zone can be validate
    if(! $zone->validate()) {
        // and if any errors, you can see them as array
        $zone->getErrorsStore()->toArray();
        // or can iterate via all, and remove invalid records for example
        foreach ($zone->getErrorsStore()->iterate() as $error) {
            if($error->isHasRecord()) {
                $error->getRecord()->remove();
            }
        }
    }
    
    // You can print zone as string, to put in in real zone file
    $content = (string) $zone;
    file_put_contents(__DIR__."/dns/zones/zone.conf", $content);
    
    // Or you can store it in array format
    $array_content = $zone->toArray();
    
    // and make zone again from array format
    Zone::fromArray("voksiv.ru.", $array_content);
    
    // also you can make zone programmatically
    $zone = new Zone("voksiv.ru.");
    $node = $zone->getNode("@");
    $node->getRecordAppender()->appendARecord("127.0.0.1");
    $node->getRecordAppender()->appendNsRecord("google.com.");
```

### Dns zone file tokenize only
if you want only tokenize zone file you can use this [library](https://github.com/LTD-Beget/dns-zone-parser) 


### Developers

## Regenerate documentation
```shell
$ ./vendor/bin/phpdox
```

### Run tests

```shell
$ php phpunit.phar --coverage-html coverage
```

## License

dns-zone-configurator is released under the MIT License.
See the [bundled LICENSE file](LICENSE) for details.
