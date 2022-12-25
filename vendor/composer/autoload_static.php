<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2149a32d185e88d8a056fa8bd807af3b
{
    public static $files = array (
        '7b6da17ee52fc1de63821b4ffee602db' => __DIR__ . '/../..' . '/config/app.php',
        'b4947a360d9e23ce405edd3b20279aa3' => __DIR__ . '/../..' . '/config/const.php',
        'e498698fb6f1e841bf7ec2b12ccada5f' => __DIR__ . '/../..' . '/config/database.php',
        'f89152891f56cdcbf5cab65eb64b21d2' => __DIR__ . '/../..' . '/helpers/helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        'd' => 
        array (
            'database\\' => 9,
        ),
        'a' => 
        array (
            'app\\' => 4,
            'admin\\app\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/database',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'admin\\app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/admin/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2149a32d185e88d8a056fa8bd807af3b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2149a32d185e88d8a056fa8bd807af3b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2149a32d185e88d8a056fa8bd807af3b::$classMap;

        }, null, ClassLoader::class);
    }
}