<?php

namespace AppBundle\Serializer;

use AppBundle\Annotation\Asset;
use Doctrine\Common\Annotations\Reader;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;

class AssetSerializationSubscriber implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $assetUrl;

    /**
     * @var Reader
     */
    private $annotationReader;

    public function __construct($assetUrl = '', Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
        $this->assetUrl = $assetUrl;
    }

    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::PRE_SERIALIZE,
                'method' => 'onPreSerialize',
                'format' => 'json',
            ]
        ];
    }

    public function onPreSerialize(ObjectEvent $event)
    {
        $object = $event->getObject();
        $annotations = $this->annotationReader
            ->getClassAnnotations(new \ReflectionObject($object));

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Asset) {
                $fields = $annotation->fields;

                $reflection = new \ReflectionObject($object);
                foreach ($reflection->getProperties() as $property) {
                    $propertyName = $property->name;
                    if (in_array($propertyName, $fields)) {
                        $property->setAccessible(true);
                        $property->setValue($object, $this->assetUrl . $property->getValue($object));
                    }
                }
            }
        }


    }
}
