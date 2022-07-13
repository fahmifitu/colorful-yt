<?php

namespace League\ColorExtractor;

class Color
{
    /**
     * @param int  $color
     * @param bool $prependHash = true
     *
     * @return string
     */
    public static function fromIntToHex($color, $prependHash = true)
    {
        return ($prependHash ? '#' : '') . sprintf('%06X', $color);
    }

    /**
     * @param string $color
     *
     * @return int
     */
    public static function fromHexToInt($color)
    {
        return hexdec(ltrim($color, '#'));
    }

    /**
     * @param int $color
     *
     * @return array
     */
    public static function fromIntToRgb($color)
    {
        return [
            'r' => $color >> 16 & 0xFF,
            'g' => $color >> 8 & 0xFF,
            'b' => $color & 0xFF,
        ];
    }

    /**
     * @param array $components
     *
     * @return int
     */
    public static function fromRgbToInt(array $components)
    {
        return ($components['r'] * 65536) + ($components['g'] * 256) + ($components['b']);
    }

    /**
     * @param string $color
     *
     * @return string
     */
    public static function getContrastColor($color)
    {
        $array = self::fromIntToRgb($color);
        $R1 = $array['r'];
        $G1 = $array['g'];
        $B1 = $array['b'];

        $L1 = 0.2126 * pow($R1 / 255, 2.2) +
            0.7152 * pow($G1 / 255, 2.2) +
            0.0722 * pow($B1 / 255, 2.2);

        $L2 = 0.2126 * pow(255 / 255, 2.2) +
            0.7152 * pow(255 / 255, 2.2) +
            0.0722 * pow(255 / 255, 2.2);

        if ($L1 > $L2) {
            $diff = ($L1 + 0.05) / ($L2 + 0.05);
        } else {
            $diff = ($L2 + 0.05) / ($L1 + 0.05);
        }
        return $diff > 5 ? 'white' : 'black';
    }
}
