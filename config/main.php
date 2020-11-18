<?php

use denobraz\editor\services\converters\Delimiter;
use denobraz\editor\services\converters\Header;
use denobraz\editor\services\converters\Image;
use denobraz\editor\services\converters\ListElement;
use denobraz\editor\services\converters\Paragraph;

return [
    'paragraph' => Paragraph::class,
    'header' => Header::class,
    'list' => ListElement::class,
    'delimiter' => Delimiter::class,
    'image' => Image::class
];