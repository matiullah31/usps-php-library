<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd56e3301537c06a80b42d5f7f9e2da82
{
    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Usps\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Usps\\' => 
        array (
            0 => __DIR__ . '/..' . '/usps/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd56e3301537c06a80b42d5f7f9e2da82::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd56e3301537c06a80b42d5f7f9e2da82::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
