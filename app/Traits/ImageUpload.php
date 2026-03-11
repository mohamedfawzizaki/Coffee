<?php

namespace App\Traits;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
trait ImageUpload
{

    public function ImageUpload($query)
    {
        $image_name = str::random(20);

        $ext = strtolower($query->getClientOriginalExtension());

        $image_full_name = $image_name.'.'.$ext;

        $upload_path = 'images/';

        $image_url = asset($upload_path.$image_full_name);

        $query->move($upload_path,$image_full_name);

        return $image_url;
    }

    /**
     * Upload images from Livewire
     * @param $livewireFile Livewire temporary file
     * @param string $folder Folder to save in (default: images)
     * @return string Image URL
     */
    public function LivewireImageUpload($livewireFile, $folder = 'images')
    {
        $image_name = Str::random(20);
        $ext = strtolower($livewireFile->getClientOriginalExtension());
        $image_full_name = $image_name.'.'.$ext;

        // Ensure the folder exists
        $upload_path = public_path($folder);
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        // Copy file from temporary path to final folder
        $temp_path = $livewireFile->getRealPath();
        $final_path = $upload_path . DIRECTORY_SEPARATOR . $image_full_name;

        if (copy($temp_path, $final_path)) {
            return asset($folder.'/'.$image_full_name);
        }

        throw new \Exception('Failed to upload image');
    }


    public function GallryUpload($gallery)
    {

        $images = [];

        foreach($gallery as $index => $file){

            $fileName = $file->getClientOriginalExtension();

            $upload_path = 'images/';

            $fileName = uniqid() .  'ecommerce.' . $fileName;

            $file->move('images/',$fileName);

            $image_url = asset($upload_path.$fileName);

            $images[] = $image_url;
        }

        return  implode(",",$images);

    }

     public function FileUpload($file, $customerId){

            $fileName = $file->getClientOriginalExtension();

            $upload_path = 'file/' . $customerId . '/';

            $fileName = uniqid() .  'alfa.' . $fileName;

            $file->move('file/' . $customerId . '/',$fileName);

            $file_url = asset('file/' . $customerId .$fileName);

            return $file_url;
     }

     public function CVUpload($query, $name){


        $name = str_replace(' ', '', $name);

        $image_name = $name . '-' . time();

        $ext = strtolower($query->getClientOriginalExtension());

        $image_full_name = $image_name.'.'.$ext;

        $upload_path = 'cv/';

        $image_url = asset($upload_path.$image_full_name);

        $query->move($upload_path,$image_full_name);

        return $image_url;

     }


     public function uploadResult($query, $id){

            $image_name = str::random(20);

            $ext = strtolower($query->getClientOriginalExtension());

            $image_full_name = $image_name.'.'.$ext;

            $upload_path = 'results/' . $id . '/';

            $image_url = asset($upload_path.$image_full_name);

            $query->move($upload_path,$image_full_name);

            return $image_url;
    }
}
