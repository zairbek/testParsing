<?php

declare(strict_types=1);

use Illuminate\Http\Testing\File;
use Tests\TestCase;

class ParsingActionTest extends TestCase
{
    public function testSuccessfully(): void
    {
        $content = file_get_contents(base_path('tests/Mocks/Files/test.xlsx'));
        $file = File::createWithContent('test.xlsx', $content);

        $response = $this->postJson(route('parsing'), [
            'file' => $file
        ]);

        $response->assertSuccessful();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidators(array $params, array $errors): void
    {
        $this->postJson(route('parsing'), $params)
            ->assertJsonValidationErrors($errors);
    }

    public static function dataProvider(): array
    {
        return [
            'not given file' => [[], ['file']],
            'incorrect file' => [['file' => File::create('docs.txt')], ['file']],
        ];
    }
}
