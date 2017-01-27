<?php
// This file is not a CODE, it makes no sense and won't run or validate
// Its AST serves IDE as DATA source to make advanced type inference decisions.

namespace PHPSTORM_META {
    $STATIC_METHOD_TYPES = [
        \Interop\Container\ContainerInterface::get('') => [
            // STATIC call key to make static (1) & dynamic (2) calls work
            "special" instanceof \Exception,
            // "KEY" instanceof Class maps KEY to Class
        ],
    ];
}
