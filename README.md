# MIM
It's module for _universal import_ *something* from *source* to some *destination*

## All you need to do is :
*  to implement the interfaces of: 
    *  \MIM\interfaces\models\Source
    *  \MIM\interfaces\models\Destination
*  _(not necessary)_ to implement the interface \MIM\interfaces\models\OffsetProvider
for saving the offset between import sessions via another thing _redis, db, etc._
_by default the OffsetProvider saves it into a file_

## Some helping things:

    There are some base models _(source, destination)_ you can extend yours from;

