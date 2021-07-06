<?php

namespace Smartbee;

class StrongStringGenerator
{
    public $MLenght = 26;
    public $AlpHabetAndSpecials ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789?#$!@`.~^&*-_+={}[]|()%";
    public const VERSION = "1.0";

    public function __construct($Lenght="", $alphabet="")
    {
        $this->MLenght = !empty($Lenght) ? $Lenght : $this->MLenght;
        $this->AlpHabetAndSpecials = !empty($alphabet) ? $alphabet : $this->AlpHabetAndSpecials;
    }

    private function CreateRandomInteger($min, $max)
    {
        if (is_numeric($max)) {
            $max += 0;
        }
        if (
            is_float($max) &&
            $max > ~PHP_INT_MAX &&
            $max < PHP_INT_MAX
        ) {
            $max = (int) $max;
        }
        if (is_numeric($min)) {
            $min += 0;
        }
        if (
            is_float($min) &&
            $min > ~PHP_INT_MAX &&
            $min < PHP_INT_MAX
        ) {
            $min = (int) $min;
        }
        if (!is_int($max)) {
            throw new TypeError('Maximum value must be an integer.');
        }
        if (!is_int($min)) {
            throw new TypeError('Minimum value must be an integer.');
        }
        if ($min > $max) {
            throw new Error('Minimum value must be less than or equal to the maximum value');
        }
        if ($max === $min) {
            return $min;
        }
        $attempts = $bits = $bytes = $mask = $valueShift = 0;

        $range = $max - $min;

        if (!is_int($range)) {
            $bytes = PHP_INT_SIZE;
            $mask = ~0;
        } else {
            while ($range > 0) {
                if ($bits % 8 === 0) {
                    ++$bytes;
                }
                ++$bits;
                $range >>= 1;
                $mask = $mask << 1 | 1;
            }
            $valueShift = $min;
        }

        do {
            if ($attempts > 128) {
                throw new Exception(
                    'random_int: RNG is broken - too many rejections'
                );
            }

            $randomByteString = random_bytes($bytes);
            if ($randomByteString === false) {
                throw new Exception(
                    'Random number generator failure'
                );
            }

            $val = 0;
            for ($i = 0; $i < $bytes; ++$i) {
                $val |= ord($randomByteString[$i]) << ($i * 8);
            }
            $val &= $mask;
            $val += $valueShift;

            ++$attempts;
        } while (!is_int($val) || $val > $max || $val < $min);
        return (int) $val;
    }

    public function CreateStrongString()
    {
        $length = $this->MLenght;
        $alphabet = $this->AlpHabetAndSpecials;
        if ($length < 1) {
            throw new InvalidArgumentException('Length must be a positive integer');
        }
        $str = '';
        $alphamax = strlen($alphabet) - 1;
        if ($alphamax < 1) {
            throw new InvalidArgumentException('Invalid alphabet');
        }
        for ($i = 0; $i < $length; ++$i) {
            $str .= $alphabet[$this->CreateRandomInteger(0, $alphamax)];
        }
        return $str;
    }
}
