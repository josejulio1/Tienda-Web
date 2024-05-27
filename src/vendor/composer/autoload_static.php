<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb26e3b61b0fdebcb3444c1add76c03b9
{
    public static $files = array (
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'View\\' => 5,
        ),
        'U' => 
        array (
            'Util\\SQL\\' => 9,
            'Util\\Permission\\' => 16,
            'Util\\Constant\\' => 14,
            'Util\\Auth\\' => 10,
            'Util\\API\\' => 9,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
        ),
        'P' => 
        array (
            'PhpOption\\' => 10,
        ),
        'M' => 
        array (
            'Model\\' => 6,
        ),
        'G' => 
        array (
            'GrahamCampbell\\ResultType\\' => 26,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
            'Database\\' => 9,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'Controller\\' => 11,
        ),
        'A' => 
        array (
            'API\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'View\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/views',
        ),
        'Util\\SQL\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/utils/sql',
        ),
        'Util\\Permission\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/utils/permissions',
        ),
        'Util\\Constant\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/utils/constants',
        ),
        'Util\\Auth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/utils/auth',
        ),
        'Util\\API\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/utils/api',
        ),
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'PhpOption\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpoption/phpoption/src/PhpOption',
        ),
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/domain/models',
        ),
        'GrahamCampbell\\ResultType\\' => 
        array (
            0 => __DIR__ . '/..' . '/graham-campbell/result-type/src',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
        'Database\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/domain/services',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
        'API\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers/api',
        ),
    );

    public static $classMap = array (
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'PhpToken' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/PhpToken.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb26e3b61b0fdebcb3444c1add76c03b9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb26e3b61b0fdebcb3444c1add76c03b9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb26e3b61b0fdebcb3444c1add76c03b9::$classMap;

        }, null, ClassLoader::class);
    }
}
