<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
     public function test_it_can_show_all_photo(): void
     {
         $response = $this->get('/photoss');
  
         $response->assertStatus(200);
     }
     public function test_it_can_show_create_photo(): void
     {
         $response = $this->get('/photos/create');
  
         $response->assertStatus(200);
     }
     public function test_it_can_show_edit_photo(): void
     {
         $response = $this->get('/photos/create');
  
         $response->assertStatus(200);
     }

     public function test_it_can_create_a_photo()
     {
         Storage::fake('photos');
 
         $file = UploadedFile::fake()->image('avatar.jpg');
         $response = $this->post('/photos', [
             'title' => 'Test title',
             'description' => 'Test Description',
             'image' => $file,
         ]);
         
 
        //  Storage::disk('photos')->assertExists($file->hashName());
         $response->assertStatus(201);
     }

     public function test_it_can_update_a_photo()
     {
         Storage::fake('photos');
 
         $photo = Photo::factory()->create();
 
         $updatedData = [
             'title' => 'Updated Title',
             'description' => 'Updated Description',
         ];
 
         $response = $this->put("/photos/{$photo->id}", $updatedData);
 
         $response->assertStatus(200);
         $this->assertDatabaseHas('photos', $updatedData);
     }

     public function test_it_can_delete_a_photo()
    {
        Storage::fake('photos');

        $photo = Photo::factory()->create();

        $response = $this->delete("/photos/{$photo->id}");

        $response->assertStatus(302);
        $this->assertDatabaseMissing('photos', ['id' => $photo->id]);
    }
 
}
