<?php
/**
 * Created by
 * User: simonewebdesign
 * Date: 11/10/12
 * Time: 18.29
 * Function that adds a single stylesheet.
 */
function add_css ($style) {
    return str_replace('$1', $style, STYLESHEET);
}