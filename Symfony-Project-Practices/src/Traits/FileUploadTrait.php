<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

trait FileUploadTrait{
    // handle file upload
    public function handleFileUpload(Request $request): Response
    {
        $uploadedFile = $request->files->get("file");
        if ($uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = uniqid() . "." . $uploadedFile->guessExtension();

            try {
                $uploadedFile->move(
                    $this->getParameter("uploads_directory"),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle exception if something happens during file upload
                return new Response("File upload failed: " . $e->getMessage());
            }

            // Return a response or redirect after successful upload
        }

        return new Response("No file uploaded"); 
    }
}