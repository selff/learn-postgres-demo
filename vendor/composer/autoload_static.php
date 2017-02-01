<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb2ea8d8cb4a0f7a6089fc1cc719ad475
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LearnPSQL\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LearnPSQL\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb2ea8d8cb4a0f7a6089fc1cc719ad475::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb2ea8d8cb4a0f7a6089fc1cc719ad475::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
