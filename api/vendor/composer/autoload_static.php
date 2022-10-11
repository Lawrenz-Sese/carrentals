<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55dd7ee7dce93b90f093d4bacb08782f
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55dd7ee7dce93b90f093d4bacb08782f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55dd7ee7dce93b90f093d4bacb08782f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55dd7ee7dce93b90f093d4bacb08782f::$classMap;

        }, null, ClassLoader::class);
    }
}
