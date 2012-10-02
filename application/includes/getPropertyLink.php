<?php
$property->link = isset($rss) ? ABSOLUTE_ROOT : ROOT;
$property->link.= 'annuncio/' . $property->_id . '/' . toAscii($property->title);