<?php

function to_slug($string){
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
}