<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb2b1b491cabd9d7331dad6cb6c2436bb
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'React\\EventLoop\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'React\\EventLoop\\' => 
        array (
            0 => __DIR__ . '/..' . '/react/event-loop/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb2b1b491cabd9d7331dad6cb6c2436bb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb2b1b491cabd9d7331dad6cb6c2436bb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb2b1b491cabd9d7331dad6cb6c2436bb::$classMap;

        }, null, ClassLoader::class);
    }
}
