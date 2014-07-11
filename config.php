<?php

$config = array(
    'twig' => array(
        'twig.path' => __DIR__.'/assets/views',
        'twig.options' => array('strict_variables' => false ),
    ),
    'globals' => array(
        "telephone" => get_registry('Telephone', ""),
        "email" => get_registry('Email', ""),
        "nav" => collection("Pages")->find(["navigation"=>true])->toArray(),
    )
);