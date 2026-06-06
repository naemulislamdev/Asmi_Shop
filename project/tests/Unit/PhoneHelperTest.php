<?php

namespace Tests\Unit;

use App\Helpers\PhoneHelper;
use PHPUnit\Framework\TestCase;

class PhoneHelperTest extends TestCase
{
    /**
     * @dataProvider phoneProvider
     */
    public function test_normalize_canonicalizes_bd_numbers($input, $expected): void
    {
        $this->assertSame($expected, PhoneHelper::normalize($input));
    }

    public static function phoneProvider(): array
    {
        return [
            'plain'                 => ['01805020340', '01805020340'],
            'with country code +'   => ['+8801805020340', '01805020340'],
            'with country code'     => ['8801805020340', '01805020340'],
            'with spaces'           => ['0 1805 020340', '01805020340'],
            'cc kept the zero'      => ['+88001805020340', '01805020340'],
            'dashes'                => ['018-0502-0340', '01805020340'],
            'empty'                 => ['', null],
            'null'                  => [null, null],
            'letters only'          => ['abc', null],
        ];
    }

    public function test_same_number_different_formats_collapse_to_one(): void
    {
        $variants = ['01805020340', '+8801805020340', '8801805020340', '0 1805 020340'];
        $normalized = array_map(fn ($v) => PhoneHelper::normalize($v), $variants);

        $this->assertCount(1, array_unique($normalized), 'All format variants must normalize to a single canonical value');
    }
}
