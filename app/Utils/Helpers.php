<?php

use App\Services\DocumentCodeGenerator;

if (!function_exists('merge')) {
    function merge($arrays)
    {
        $result = [];

        foreach ($arrays as $array) {
            if ($array !== null) {
                if (gettype($array) !== 'string') {
                    foreach ($array as $key => $value) {
                        if (is_integer($key)) {
                            $result[] = $value;
                        } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                            $result[$key] = merge([$result[$key], $value]);
                        } else {
                            $result[$key] = $value;
                        }
                    }
                } else {
                    $result[count($result)] = $array;
                }
            }
        }

        return join(" ", $result);
    }
}

if (!function_exists('uncamelize')) {
    function uncamelize($camel, $splitter = "_")
    {
        $camel = preg_replace('/(?!^)[[:upper:]][[:lower:]]/', '$0', preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $camel));
        return strtolower($camel);
    }
}

if (!function_exists('format_currency')) {
    function format_currency($value, $currency = 'USD')
    {
        return number_format((float) $value, 2) . ' ' . $currency;
    }
}

if (!function_exists('generate_document_code')) {
    function generate_document_code(string $documentType): string
    {
        return app(DocumentCodeGenerator::class)->generate($documentType);
    }
}

if (!function_exists('getFileList')) {
    function getFileList($directory, $extensions)
    {
        $files = [];

        if (is_dir($directory)) {
            $scannedFiles = scandir($directory);
            foreach ($scannedFiles as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }

                $fileExtension = explode('.', $file);
                if (in_array(end($fileExtension), explode(',', $extensions))) {
                    $files[] = str_replace(base_path() . '/', '', '/' . implode('/', array_filter(explode('/', $directory), 'strlen')) . '/' . $file);
                }
            }
        }

        return $files;
    }
}
