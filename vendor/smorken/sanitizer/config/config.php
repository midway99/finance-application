<?php
return [
    'default' => 'standard',
    'sanitizers' => [
        'standard' => \Smorken\Sanitizer\Sanitizers\Standard::class,
        'sis' => \Smorken\Sanitizer\Sanitizers\RdsCds::class,
    ],
    'purifier_options' => [
        'Core.Encoding' => 'UTF-8',
        'AutoFormat.AutoParagraph' => true,
        'AutoFormat.RemoveEmpty' => true
    ]
];
