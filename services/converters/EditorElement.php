<?php

namespace denobraz\editor\services\converters;

interface EditorElement
{
    public function convert(array $element): string;
}