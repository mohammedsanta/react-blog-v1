<?php

use App\Models\Tag;

if(!function_exists('tags')){
    function tags() {
        return Tag::all();
    }
}

if(!function_exists('route_path')){
    function route_path($path) {
        return $_SERVER['REQUEST_URI'] == $path;
    }
}
