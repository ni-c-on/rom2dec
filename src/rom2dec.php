<?php

namespace rom2dec;

class rom2dec
{
    public static function convert($string) {

        $string = strtolower($string);

        $_FSM_table = [
            'init' => ['m' => [1000, 'init'], 'd' => [500, 'd'  ], 'c' => [100, 'cmcd'], 'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'd'    => ['m' => false,          'd' => false,        'c' => [100, 'c'   ], 'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'c'    => ['m' => false,          'd' => false,        'c' => [100, 'cc'  ], 'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'cc'   => ['m' => false,          'd' => false,        'c' => [100, 'ccc' ], 'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'cmcd' => ['m' => [ 800, 'ccc' ], 'd' => [300, 'ccc'], 'c' => [100, 'cc'  ], 'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'ccc'  => ['m' => false,          'd' => false,        'c' => false,         'l' => [50,  'l' ], 'x' => [10,  'xcxl'], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'l'    => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => [10,  'x'   ], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'x'    => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => [10,  'xx'  ], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'xx'   => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => [10,  'xxx' ], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'xcxl' => ['m' => false,          'd' => false,        'c' => [ 80, 'xxx' ], 'l' => [30, 'xxx'], 'x' => [10,  'xx'  ], 'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'xxx'  => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => false,         'v' => [5, 'v'], 'i' => [1, 'ixiv']],
            'v'    => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => false,         'v' => false,    'i' => [1, 'i'   ]],
            'i'    => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => false,         'v' => false,    'i' => [1, 'ii'  ]],
            'ii'   => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => false,         'v' => false,    'i' => [1, 'iii' ]],
            'ixiv' => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => [ 8,  'iii' ], 'v' => [3, 'v'], 'i' => [1, 'ii'  ]],
            'iii'  => ['m' => false,          'd' => false,        'c' => false,         'l' => false,       'x' => false,         'v' => false,    'i' => false      ],
        ];

        $state = 'init';
        $result = 0;

        for ($i = 0; $i < strlen($string); ++$i) {
            $symbol = $string[$i];

            if (!isset($_FSM_table[$state][$symbol]) || $_FSM_table[$state][$symbol] === false) {
                throw new \InvalidArgumentException("Invalid symbol at offset $i");
            }
            $result += $_FSM_table[$state][$symbol][0];
            $state = $_FSM_table[$state][$symbol][1];
        }

        return $result;
    }
}
