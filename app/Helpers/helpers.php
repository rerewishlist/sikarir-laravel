<?php

if (!function_exists('setActive')) {
    function setActive($path, $active = '', $collapsed = 'collapsed')
    {
        return request()->is($path) ? $active : $collapsed;
    }
}
