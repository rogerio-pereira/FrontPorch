<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\JsonSchema\Types\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Image;
use Laravel\Ai\Tools\Request;
use Stringable;

class GenerateImageTool implements Tool
{
    public function name(): string
    {
        return 'generate_image';
    }

    public function description(): Stringable|string
    {
        return 'Generate an image from an idea, upload it on the default disk, and return the public URL.';
    }

    public function handle(Request $request): Stringable|string
    {
        $idea = (string) $request->string('idea');
        $directory = (string) $request->string('directory', 'blog');

        if ($directory === '') {
            $directory = 'blog';
        }

        $rules = '';
        $rulesPath = base_path('docs/ai/ImageGenerator.md');

        if (is_readable($rulesPath)) {
            $rules = (string) file_get_contents($rulesPath);
        }

        $response = Image::of(trim($idea."\n\n".$rules))
                        ->landscape()
                        ->generate(Lab::OpenAI);

        $filename = Str::uuid()->toString().'.png';
        $path = $response->storePubliclyAs($directory, $filename);

        return Storage::url($path);
    }

    /**
     * @return array<string, Type>
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'idea' => $schema->string()
                            ->description('What the image should show.')
                            ->required(),
            'directory' => $schema->string()
                                ->description('Storage folder on the default disk (default: blog).'),
        ];
    }
}
