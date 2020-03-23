<?php

return [
    // draw
    [
        'id' => 'faede872-a75e-453e-b7eb-29a70f7c7e85',
        'status' => 'RUNNING',
        'board' => '0XXXX000-', // => 0XXXX000X
    ],
    // win
    [
        'id' => 'ea51b15c-2618-49dc-aef6-80fe54ec1a7a',
        'status' => 'RUNNING',
        'board' => 'X-X0-00-X', // => X-X0X00-X
    ],
    // lose
    [
        'id' => '907e6592-b2cf-4dc1-b282-b141735952ad',
        'status' => 'RUNNING',
        'board' => '00-0XX-X-', // => 00-0XX-XX
    ],
    // completed draw
    [
        'id' => '96d3e336-71df-4877-a7fb-3689484167f7',
        'status' => 'DRAW',
        'board' => '0XXXX000X', // => 0XXXX000X
    ],
];
