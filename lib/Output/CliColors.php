<?php

namespace Clipper\Output;

class CliColors
{
    public static $FG_BLACK = '0;30';
    public static $FG_WHITE = '1;37';
    public static $FG_RED = '0;31';
    public static $FG_GREEN = '0;32';
    public static $FG_BLUE = '1;34';
    public static $FG_CYAN = '0;36';
    public static $FG_MAGENTA = '0;35';

    public static $BG_BLACK = '40';
    public static $BG_RED = '41';
    public static $BG_GREEN = '42';
    public static $BG_BLUE = '44';
    public static $BG_CYAN = '46';
    public static $BG_WHITE = '47';
    public static $BG_MAGENTA = '45';

    public static $THEME_REGULAR = 1;
    public static $THEME_UNICORN = 2;

    public static function palette($name = 'regular')
    {
        $themes['regular'] = [
            'default'     => [ CliColors::$FG_WHITE ],
            'alt'         => [ CliColors::$FG_BLACK, CliColors::$BG_WHITE ],
            'error'       => [ CliColors::$FG_RED ],
            'error_alt'   => [ CliColors::$FG_WHITE, CliColors::$BG_RED ],
            'success'     => [ CliColors::$FG_GREEN ],
            'success_alt' => [ CliColors::$FG_WHITE, CliColors::$BG_GREEN ],
            'info'        => [ CliColors::$FG_CYAN],
            'info_alt'    => [ CliColors::$FG_WHITE, CliColors::$BG_CYAN ]
        ];

        $themes['unicorn'] = [
            'default'     => [ CliColors::$FG_CYAN ],
            'alt'         => [ CliColors::$FG_BLACK, CliColors::$BG_CYAN ],
            'error'       => [ CliColors::$FG_RED ],
            'error_alt'   => [ CliColors::$FG_CYAN, CliColors::$BG_RED ],
            'success'     => [ CliColors::$FG_GREEN ],
            'success_alt' => [ CliColors::$FG_BLACK, CliColors::$BG_GREEN ],
            'info'        => [ CliColors::$FG_MAGENTA],
            'info_alt'    => [ CliColors::$FG_WHITE, CliColors::$BG_MAGENTA ]
        ];

        return isset($themes[$name]) ? $themes[$name] : $themes['regular'];
    }
}
