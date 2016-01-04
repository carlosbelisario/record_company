<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArtistTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * test list
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->call('GET', '/artists/list');
        $this->assertJson($response->getContent());
    }

    /**
     * test add success
     */
    public function testAddSuccess()
    {
        $this->post('/artists/create', $this->getFormData())->seeJson([
            'status' => 'success'
        ]);
    }

    /**
     * test add invalid
     */
    public function testAddInvalid()
    {
        $this->post('/artists/create', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    /**
     * test edit success
     */
    public function testEditSuccess()
    {
        $this->factoryArtist();
        $this->put('/artists/edit/2', $this->getFormData())->seeJson([
                'status' => 'success'
        ]);
    }

    /**
     * test edit not found
     */
    public function testEditNotFound()
    {
        $this->put('/artists/edit/100000', $this->getFormDataIvalid())->seeJson([
            'status' => 'error',
            'message' => 'artista no encontrado',
        ]);
    }

    /**
     * test edit invalid
     */
    public function testEditInvalid()
    {
        $this->factoryArtist();
        $expectedErrors = new \stdClass();
        $expectedErrors->title[] = 'El campo Título es obligatorio';
        $expectedErrors->published[] = 'El campo Fecha de Publicación es obligatorio';
        $expectedErrors->author[] = 'El campo Artista es obligatorio';
        $this->put('/artists/edit/2', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    public function testDetail()
    {
        $this->factoryArtist();
        $response = $this->call('GET', '/artists/detail/2');
        $data = $this->parseJson($response);
        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('name', $data);
        $this->assertObjectHasAttribute('album', $data);
        $this->assertObjectHasAttribute('roles', $data);
    }

    /**
     * @param \Illuminate\Http\JsonResponse $response
     * @return mixed
     */
    protected function parseJson(Illuminate\Http\JsonResponse $response)
    {
        return json_decode($response->getContent());
    }

    protected function getFormData()
    {
        return ['name' => 'artist test', 'rol' => [1]];
    }

    protected function getFormDataIvalid()
    {
        return ['name' => '', 'rol' => ''];
    }

    protected function factoryArtist()
    {
        $artist = factory(App\Model\Artist::class, 2)
            ->create()
            ->each(function($a) {
                $a->roles()->save(factory(App\Model\Roles::class)->make());
            })
        ;
    }

}
