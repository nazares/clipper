<?php

use helpers\Color;

require_once 'Color.php';

function getColor(Color $color): int
{
    return $color->value;
}

function setColor(
    string $str,
    Color $foreground = Color::Default,
    Color $background = Color::Default,
    int $style = 0
): string {
    return sprintf("\e[%s;9%s;10%sm%s\e[0m", $style, getColor($foreground), getColor($background), $str);
}

function btree($array, $tab = "  ", $result = '')
{
    foreach ($array as $key => $value) {
        $strLength = is_string($value) ? mb_strlen($value) : null;
        $key = is_string($key) ?
        sprintf(
            "'%s'",
            setColor($key, Color::Red)
        ) : sprintf(
            "[%s]",
            setColor($key, Color::Green)
        );

        $value = is_string($value) ? sprintf("\"%s\"", setColor($value, Color::Red)) : $value;

        if (is_array($value)) {
            $result .= sprintf(
                "%s%s %s => {" . PHP_EOL,
                $tab,
                $key,
                "array(" . setColor(count($value), Color::Green) . ")"
            );

            $result .= btree($value, $tab . str_repeat(' ', 4));
            $result .= "{$tab}}\n";
        } else {
            $type = gettype($value);

            if ($type === 'boolean') {
                $type = setColor('bool', Color::Magenta);
                $value = '(' . setColor($value ? 'true' : 'false', Color::Cyan, Color::Default, 3) . ')';
            }


            if ($type === 'integer') {
                $value = setColor($value, Color::Green);
                $value = "(" . $value . ")";
                $type = setColor('int', Color::Magenta);
            }
            if ($type === 'double') {
                $value = setColor($value, Color::Yellow);
                $value = "(" . $value . ")";
                $type = setColor('float', Color::Magenta);
            }

            if ($type === 'NULL') {
                $type = setColor('null', Color::Blue);
            }

            if ($type === 'string') {
                $type = setColor($type, Color::Magenta) . "(" . setColor($strLength, Color::Green) ."): ";
            }
            $result .= "{$tab}$key =>  $type$value" . PHP_EOL;
        }
    }

    return $result;
}

if (!function_exists('dbg')) {
    function dbg(...$args): void
    {
        echo setColor("\n\n\tDUMP INFO\t\n", Color::White, Color::Red) .PHP_EOL;

        $info = debug_backtrace()[0];

        echo "\n";

        foreach ($args as $arg) {
            echo sprintf(
                "%s:%s:",
                setColor($info['file'], Color::Default, Color::Default, 1),
                setColor($info['line'], Color::Default, Color::Default, 2)
            ). PHP_EOL;

            $type = gettype($arg);

            if (is_numeric($arg)) {
                if (is_int($arg)) {
                    $fg = Color::Green;
                }
                if (is_float($arg)) {
                    $fg = Color::Yellow;
                }

                $type = is_int($arg) ? 'int' : 'float';
                $value = sprintf("(%s)", setColor($arg, $fg));
            }

            if (is_string($arg)) {
                $value = sprintf("(%s) \"%s\"", setColor(mb_strlen($arg), Color::Green), setColor($arg, Color::Red));
            }

            if (is_bool($arg)) {
                $type = 'bool';
                $value = sprintf("(%s)", setColor($arg ? 'true' : 'false', Color::Cyan, Color::Default, 3));
            }

            if (is_array($arg)) {
                $value = sprintf("(%s) {". PHP_EOL, count($arg));

                $value .= btree($arg);
                $value .= "}";
            }

            if (is_null($arg)) {
                $type = setColor($type, Color::Blue);
                $value = $arg;
            }

            if (is_object($arg)) {
                // $value = '';
                $type = 'class';
                $class = new ReflectionClass($arg);

                $value = sprintf(
                    "%s#%s (%s) {\n",
                    setColor($class->getName(), Color::Red),
                    spl_object_id($arg),
                    setColor(count(get_mangled_object_vars($arg)), Color::Green)
                );

                foreach (get_mangled_object_vars($arg) as $var => $val) {
                    $proptype = gettype($val);
                    if (gettype($val) === 'array') {
                        $count = count($val);
                        $value .= sprintf(
                            "%s %s %s =>\n%s(%s) {" . PHP_EOL,
                            setColor('protected', Color::Green, Color::Default, 1),
                            setColor($proptype, Color::Green, Color::Default, 2),
                            str_replace("*", "$", $var),
                            setColor($proptype, Color::Magenta, Color::Default, 2),
                            setColor($count, Color::Cyan)
                        );
                        $value .= btree($val);
                        $value .= "}" . PHP_EOL;
                    } else {
                        $len = mb_strlen($val);
                        $value .= sprintf(
                            "%s %s(%s) %s => \"%s\"\n",
                            setColor('protected', Color::Green),
                            setColor($proptype, Color::Green, Color::Default, 2),
                            setColor($len, Color::Cyan),
                            str_replace("*", "$", $var),
                            setColor($val, Color::Red)
                        );
                    }
                }

                $value .=  "}";

                if ((new ReflectionClass($arg))->isEnum()) {
                    $type = 'enum';
                    $enum = new ReflectionEnum($arg);
                    $value = sprintf(
                        " %s::%s : %s(%s);",
                        setColor($enum->getName(), Color::Red),
                        setColor($arg->name, Color::Red),
                        setColor(gettype($arg->value) === 'integer' ? 'int' : gettype($arg->value), Color::Magenta),
                        setColor($arg->value, Color::Green)
                    );
                }

                if ((new ReflectionClass($arg))->isTrait()) {
                    $type = 'trait';
                }

                if ((new ReflectionClass($arg))->isInterface()) {
                    $type = 'interface';
                }
            }

            echo setColor($type, Color::Magenta) . $value . PHP_EOL;
        }
    }
}
