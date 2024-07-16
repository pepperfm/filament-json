<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;

$rules = [
    '@Symfony' => true,
    '@PSR12' => true,
    '@PSR12:risky' => true,
    '@PHP80Migration' => true,
    '@PHP80Migration:risky' => true,
    '@PHPUnit84Migration:risky' => true,
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,

    'ordered_imports' => [
        'sort_algorithm' => 'none',
    ],
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'case',
            'constant_public',
            'constant_protected',
            'constant_private',
            'property_public',
            'property_protected',
            'property_private',
            'construct',
            'destruct',
            'magic',
            'phpunit',
        ],
    ],

    'concat_space' => ['spacing' => 'one'],
    'cast_spaces' => ['space' => 'single'],
    'braces_position' => [
        'anonymous_classes_opening_brace' => 'same_line',
    ],
    'control_structure_braces' => true,
    'blank_line_between_import_groups' => true,
    'single_line_empty_body' => false,
    'single_trait_insert_per_statement' => false,
    'blank_line_before_statement' => false,
    'function_declaration' => [
        'closure_fn_spacing' => 'none',
    ],
    'fully_qualified_strict_types' => false,
    'increment_style' => [
        'style' => 'post',
    ],
    'method_argument_space' => [
        'on_multiline' => 'ignore',
    ],

    'new_with_parentheses' => [
        'anonymous_class' => false,
    ],
    'no_superfluous_phpdoc_tags' => false,

    'phpdoc_annotation_without_dot' => true,
    'phpdoc_align' => [
        'align' => 'left',
        'tags' => [
            'param',
            'property',
            'property-read',
            'property-write',
            'var',
            'type',
            'throws',
            'return',
        ],
    ],
    'phpdoc_add_missing_param_annotation' => [
        'only_untyped' => false,
    ],
    'phpdoc_to_comment' => [
        'ignored_tags' => [
            'link', 'see',
        ],
    ],
    'phpdoc_tag_type' => [
        'tags' => [
            'api' => 'annotation',
            'author' => 'annotation',
            'copyright' => 'annotation',
            'deprecated' => 'annotation',
            'example' => 'annotation',
            'global' => 'annotation',
            'internal' => 'annotation',
            'license' => 'annotation',
            'method' => 'annotation',
            'package' => 'annotation',
            'param' => 'annotation',
            'property' => 'annotation',
            'return' => 'annotation',
            'see' => 'annotation',
            'since' => 'annotation',
            'throws' => 'annotation',
            'todo' => 'annotation',
            'uses' => 'annotation',
            'var' => 'annotation',
            'version' => 'annotation',
        ],
    ],
    'phpdoc_order' => [
        'order' => ['param', 'throw', 'return'],
    ],
    'phpdoc_return_self_reference' => [
        'replacements' => [
            'this' => '$this',
            '@this' => '$this',
            '$self' => 'static',
            '@self' => 'static',
            '$static' => 'static',
            '@static' => 'static',
        ],
    ],
    'phpdoc_separation' => [
        'groups' => [
            [
                'deprecated',
                'link',
                'see',
                'since',
            ],
            [
                'author',
                'copyright',
                'license',
            ],
            [
                'category',
                'package',
                'subpackage',
            ],
            [
                'param',
                'property',
                'property-read',
                'property-write',
            ],
            [
                'return',
            ],
            [
                'OA\*',
                '#[*',
            ],
        ],
    ],
    'phpdoc_tag_casing' => [
        'tags' => [
            'inheritdoc',
        ],
    ],
    'phpdoc_var_without_name' => false,
    'phpdoc_to_property_type' => true,
    'phpdoc_to_return_type' => true,
    'phpdoc_types_order' => [
        'null_adjustment' => 'always_last',
    ],
    'phpdoc_summary' => false,
    'phpdoc_no_empty_return' => false,

    'operator_linebreak' => false,

    'global_namespace_import' => [
        'import_classes' => false,
    ],
    'single_import_per_statement' => false,
    'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],

    'fopen_flags' => ['b_mode' => true],

    'php_unit_strict' => false,
    'php_unit_test_class_requires_covers' => false,
    'php_unit_test_case_static_method_calls' => ['call_type' => 'this'],
    'php_unit_method_casing' => false,
    'php_unit_set_up_tear_down_visibility' => false,
    'php_unit_internal_class' => false,

    'yoda_style' => false,

    'final_class' => false,
    'final_public_method_for_abstract_class' => false,
    'self_static_accessor' => false,
    'single_line_comment_style' => [
        'comment_types' => ['hash'],
    ],
    'static_lambda' => true,
    'native_function_invocation' => [
        'include' => [NativeFunctionInvocationFixer::SET_COMPILER_OPTIMIZED],
        'scope' => 'namespaced',
        'strict' => false,
        'exclude' => [
            'json_encode', 'json_decode', 'in_array', 'is_array', 'is_int',
            'is_string', 'is_null', 'count', 'strlen', 'array_key_exists', 'array_slice',
            'get_class', 'func_get_args', 'call_user_func',
        ],
    ],
    'native_constant_invocation' => [
        'strict' => false,
        'fix_built_in' => false,
    ],
    'explicit_indirect_variable' => false,
    'explicit_string_variable' => false,
    'is_null' => false,
    'no_leading_import_slash' => false,
    'no_unreachable_default_argument_value' => false,

    'use_arrow_functions' => true,
];

$finder = Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/config',
    ])
    ->append([
        __FILE__,
    ])
    ->name('*.php')
    ->notPath(['vendor'])
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setCacheFile(__DIR__ . '/.php_cs')
    ->setFinder($finder)
    ->setRules($rules);
