<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    protected $manager;
    
    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }
    
    public function upload(UploadedFile $file, string $path = 'images', array $sizes = []): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $image = $this->manager->read($file->getPathname());
        
        $results = [];
        
        // Original image
        $originalPath = $path . '/original/' . $filename;
        Storage::disk('public')->put($originalPath, $image->encode());
        $results['original'] = $originalPath;
        
        // Generate different sizes
        $defaultSizes = config('image.sizes', []);
        $sizes = array_merge($defaultSizes, $sizes);
        
        foreach ($sizes as $sizeName => $dimensions) {
            $resized = $image->resize($dimensions[0], $dimensions[1], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $sizePath = $path . '/' . $sizeName . '/' . $filename;
            Storage::disk('public')->put($sizePath, $resized->encode());
            $results[$sizeName] = $sizePath;
        }
        
        return $results;
    }
    
    public function delete(array $paths): void
    {
        foreach ($paths as $path) {
            Storage::disk('public')->delete($path);
        }
    }
}