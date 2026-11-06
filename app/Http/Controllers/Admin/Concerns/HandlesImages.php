<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\Media;
use Illuminate\Http\Request;

/**
 * Image fields posted by the admin.partials.image-input partial:
 *   {field}         stored path or URL (editable text)
 *   {field}_file    optional upload, wins over the text path
 *   remove_{field}  optional checkbox to clear the image
 */
trait HandlesImages
{
    /**
     * Validation rules for an image field and its upload.
     */
    protected function imageRules(string $field, bool $required = false): array
    {
        return [
            $field => array_merge($required ? ["required_without:{$field}_file"] : [], ['nullable', 'string', 'max:500']),
            "{$field}_file" => Media::rules(),
        ];
    }

    /**
     * Resolve the value to store for an image field, uploading/deleting files as needed.
     */
    protected function resolveImage(Request $request, string $field, ?string $current, string $folder): ?string
    {
        if ($request->hasFile("{$field}_file")) {
            return Media::replace($request->file("{$field}_file"), $current, $folder);
        }

        if ($request->boolean("remove_{$field}")) {
            Media::delete($current);

            return null;
        }

        $path = trim((string) $request->input($field)) ?: null;

        if ($current && $path !== $current) {
            Media::delete($current);
        }

        return $path;
    }

    /**
     * Resolve several image fields onto $data.
     */
    protected function resolveImages(Request $request, array $data, array $fields, $model, string $folder): array
    {
        foreach ($fields as $field) {
            $data[$field] = $this->resolveImage($request, $field, $model?->{$field}, $folder);
            unset($data["{$field}_file"], $data["remove_{$field}"]);
        }

        return $data;
    }

    /**
     * Delete uploaded files of a model being removed.
     */
    protected function deleteImages($model, array $fields): void
    {
        foreach ($fields as $field) {
            Media::delete($model->{$field});
        }
    }
}
