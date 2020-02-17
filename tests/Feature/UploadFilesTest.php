<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class UploadFilesTest extends TestCase
{
    use RefreshDatabase;

    public function testExample()
    {
      //Storage::fake('avatars');

      $response = $this->json('POST', '/api/media', [
          'avatar' => UploadedFile::fake()->image('avatar.jpg'),
          'title'  => 'Bicha',
          'store_in_folder'  => 'managu',
          'store_in_disk' => 'local',
          'duration' => null,
      ]);
      
      $response->assertStatus(200)->assertJson([
                'title' => 'Bicha'
            ]);
      
    }
}
