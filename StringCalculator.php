<?php
declare(strict_types=1);

namespace Src\StringCalculator;

class StringCalculator
{
    static public function getPrioritet($val): int
        {
            if ($val == '*' || $val == '/') return 3;
            elseif ($val == '+' || $val == '-') return 2;
            elseif ($val == 's' || $val == 'c') return 4;
            elseif ($val == '(') return -1;
            elseif ($val == ')') return 1;
            else return 0;
        }
    static public function getStringCalculator(string $string): float
    {
        if($string == '') return 0;
        $string = mb_eregi_replace('in|os|[ ]', '', $string);
        $ar = array();
        for ($i = 0; $i <= mb_strlen($string); $i++){
            if (is_numeric(mb_substr($string, $i, 1))){
                $numinfo = mb_substr($string, $i, 1);
                $z = $i+1;
                while (is_numeric(mb_substr($string, $z, 1)) or mb_substr($string, $z, 1) == '.'){
                    $numinfo .= mb_substr($string, $z, 1);
                    $z++;
                }
                array_push($ar, $numinfo);
                if ($z >= mb_strlen($string)) break;
                $i = $z-1;
            }
            else array_push($ar, mb_substr($string, $i, 1));
        }
        if (end($ar) == '') array_pop($ar);
        if ($ar[0] == '+') array_shift($ar);

        $nums = array();
        $actions = array();

        $minuses = array_keys($ar, '-');

        for ($i = 0; $i <= count($minuses)-1; $i++){
            if ($minuses[$i]!=0 && $ar[$minuses[$i]-1] == '(' && is_numeric($ar[$minuses[$i]+1])){
                $newvalue = $ar[$minuses[$i]+1];
                $ar[$minuses[$i]+1] = '-' . $newvalue;
                unset($ar[$minuses[$i]]);
            }
        }
        $ar = array_values($ar);

        for ($i = 0; $i <= count($ar)-1; $i++){
            if (self::getPrioritet($ar[$i]) == 0){
                array_unshift($nums, $ar[$i]);
            }
            elseif (self::getPrioritet($ar[$i]) == -1){
                array_unshift($actions, $ar[$i]);
            }
            elseif (self::getPrioritet($ar[$i]) == 1){
                while(current($actions) != '('){
                    if (current($actions) == '*'){
                        $y = array_shift($nums);
                        $x = array_shift($nums);
                        $nstep = $x * $y;
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                    elseif (current($actions) == '/'){
                        $y = array_shift($nums);
                        $x = array_shift($nums);
                        $nstep = $x / $y;
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                    elseif (current($actions) == 's'){
                        $x = (float) array_shift($nums);
                        $nstep = sin($x);
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                    elseif (current($actions) == 'c'){
                        $x = (float) array_shift($nums);
                        $nstep = cos($x);
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                    elseif (current($actions) == '-'){
                        $y = array_shift($nums);
                        $x = array_shift($nums);
                        $nstep = $x - $y;
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                    elseif (current($actions) == '+'){
                        $y = array_shift($nums);
                        $x = array_shift($nums);
                        $nstep = $x + $y;
                        array_unshift($nums, $nstep);
                        array_shift($actions);
                    }
                }
                array_shift($actions);
            }
            else{
                if (!empty($actions)){
                    while(self::getPrioritet($ar[$i]) <= self::getPrioritet(current($actions))){
                        if (current($actions) == '*'){
                            $y = array_shift($nums);
                            $x = array_shift($nums);
                            $nstep = $x * $y;
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                        elseif (current($actions) == '/'){
                            $y = array_shift($nums);
                            $x = array_shift($nums);
                            $nstep = $x / $y;
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                        elseif (current($actions) == 's'){
                            $x = (float) array_shift($nums);
                            $nstep = sin($x);
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                        elseif (current($actions) == 'c'){
                            $x = (float) array_shift($nums);
                            $nstep = cos($x);
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                        elseif (current($actions) == '-'){
                            $y = array_shift($nums);
                            $x = array_shift($nums);
                            $nstep = $x - $y;
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                        elseif (current($actions) == '+'){
                            $y = array_shift($nums);
                            $x = array_shift($nums);
                            $nstep = $x + $y;
                            array_unshift($nums, $nstep);
                            array_shift($actions);
                        }
                    }
                }
                array_unshift($actions, $ar[$i]);
            }
        }

        while (!empty($actions)){
            if (current($actions) == '*'){
                $y = array_shift($nums);
                $x = array_shift($nums);
                $nstep = $x * $y;
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
            elseif (current($actions) == '/'){
                $y = array_shift($nums);
                $x = array_shift($nums);
                $nstep = $x / $y;
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
            elseif (current($actions) == 's'){
                $x = (float) array_shift($nums);
                $nstep = sin($x);
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
            elseif (current($actions) == 'c'){
                $x = (float) array_shift($nums);
                $nstep = cos($x);
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
            elseif (current($actions) == '-'){
                $y = array_shift($nums);
                $x = array_shift($nums);
                $nstep = $x - $y;
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
            elseif (current($actions) == '+'){
                $y = array_shift($nums);
                $x = array_shift($nums);
                $nstep = $x + $y;
                array_unshift($nums, $nstep);
                array_shift($actions);
            }
        }
        return round((float) current($nums), 4);
    }
}