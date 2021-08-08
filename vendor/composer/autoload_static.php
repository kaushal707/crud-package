<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdf53431239027e93b03d54e5ff2fe318
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Kaushal\\Crud\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Kaushal\\Crud\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdf53431239027e93b03d54e5ff2fe318::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdf53431239027e93b03d54e5ff2fe318::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdf53431239027e93b03d54e5ff2fe318::$classMap;

        }, null, ClassLoader::class);
    }
}
