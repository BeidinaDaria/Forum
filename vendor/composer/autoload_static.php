<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab88c080076805d1349e32611e34d6e3
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitab88c080076805d1349e32611e34d6e3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab88c080076805d1349e32611e34d6e3::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitab88c080076805d1349e32611e34d6e3::$classMap;

        }, null, ClassLoader::class);
    }
}
