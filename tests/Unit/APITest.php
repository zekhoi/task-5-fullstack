<?php

namespace Tests\Unit;

use Tests\TestCase;
use Laravel\Passport\Passport;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Http\Middleware\Authenticate;
use App\Models\Article;

class APITest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    
    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // login
        $this->user = User::factory()->create();
        $this->withoutMiddleware(Authenticate::class);
    }

    public function test_articles_index()
    {
        $this->actingAs($this->user)->get('/api/v1/articles')->assertStatus(200);
    }
    
    public function test_articles_show()
    {
        $this->actingAs($this->user)->get('/api/v1/articles/1')->assertStatus(200);
    }

    public function test_articles_store()
    {
        $article = [
            'title' => 'Ini artikel buat create',
            'image' => 'https://laravel-blog-assets.s3.amazonaws.com/c5CtKWWHMlT0ZoWa0grGDUCdcYCxRO8JbfPxH66S.png',
            'category_id'=> '1',
            'user_id' => $this->user->id,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut semper, diam vitae lacinia faucibus, quam massa finibus massa, a feugiat turpis enim ut turpis. Sed mollis mattis massa vel auctor. Cras posuere purus id tellus scelerisque, at malesuada quam lacinia. Nam hendrerit dui quis porttitor vehicula. Phasellus luctus, lacus sit amet facilisis vulputate, nulla augue maximus quam, vel posuere massa metus in mi. Curabitur vel arcu scelerisque, imperdiet purus sit amet, ultrices ipsum. Etiam efficitur est sagittis augue placerat, quis blandit nisi ullamcorper. Ut felis mauris, sodales a posuere vel, mattis sed magna. Vestibulum vitae orci et eros vestibulum malesuada in eget nisl. Nullam vitae ipsum imperdiet, commodo felis non, condimentum lorem.'
        ];

        $this->actingAs($this->user)->post('/api/v1/articles', $article)->assertStatus(201);
    }

    public function test_articles_update()
    {   
        $oldData = [
            'title' => 'Ini artikel buat create',
            'image' => null,
            'category_id'=> '2',
            'user_id' => $this->user->id,
            'content' => ' Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac velit sit amet nulla dignissim convallis in non velit. Vestibulum id odio odio. Donec vel magna lobortis, blandit elit quis, imperdiet mi. Vestibulum posuere magna id finibus pharetra. Sed eu augue egestas, tempor purus quis, porta magna. Nunc consequat cursus luctus. Sed at nunc risus. Nulla nec odio enim. Suspendisse vestibulum libero sed velit congue pretium. Maecenas sit amet suscipit dolor.'
        ];

        $newData = [
            'title' => 'Ini artikel buat update',
            'image' => 'https://zekhoi.my.id/_next/image?url=%2Fimages%2Fthumbnails%2Fdatabase-coding.jpg&w=1920&q=75',
            'category_id'=> '1',
            'user_id' => $this->user->id,
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ornare, nisl id ultrices dapibus, purus dui interdum justo, eu lobortis turpis est at nibh. Nam luctus quam in lobortis pretium. Etiam sit amet sodales mi, a aliquet est. Curabitur mi justo, gravida non feugiat eget, efficitur eu nulla. Proin eu congue lacus. Nullam pulvinar ultricies gravida. Duis vehicula augue nec velit sagittis, in molestie mi posuere. Pellentesque efficitur eget tortor vitae tincidunt. Aliquam volutpat ex nec purus porta vehicula. Quisque semper iaculis lectus ut gravida.'
        ];
        
        $oldArticle = Article::factory()->create($oldData);
        
        $this->actingAs($this->user)->put('/api/v1/articles/' . $oldArticle->id, $newData)->assertStatus(201);
    }

    public function test_articles_destroy()
    {   
        $article = Article::factory()->create([
            'user_id' => $this->user->id
        ]);
        
        $this->actingAs($this->user)->delete('/api/v1/articles/' . $article->id)->assertStatus(200);
    }
}