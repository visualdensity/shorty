<?php
namespace Shorty\Service\UrlBundle\Entity;

class AbstractEntity
{

    public function toArray()
    {
        $reflect = new \ReflectionClass($this);
        $props   = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);

        foreach($props as $p) {
            $val = $this->{$p->getName()};

            if( $val instanceof \DateTime ) {
                $data[ $p->getName() ] = $val->format('Y-m-d H:i:s');
            } else {
                $data[ $p->getName() ] = $val;
            }
        }

        return $data;
    }

}
