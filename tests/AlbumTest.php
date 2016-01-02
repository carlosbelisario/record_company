<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AlbumTest extends TestCase
{
    /**
     * test list
     *
     * @return void
     */
    public function testList()
    {
        $response = $this->call('GET', '/albums/list');
        $this->assertJson($response->getContent());
    }

    /**
     * test add success
     */
    public function testAddSuccess()
    {
        $this->post('/albums/create', $this->getFormData())->seeJson([
            'status' => 'success'
        ]);
    }

    /**
     * test add invalid
     */
    public function testAddInvalid()
    {
        $expectedErrors = new \stdClass();
        $expectedErrors->title[] = 'El campo Título es obligatorio';
        $expectedErrors->published[] = 'El campo Fecha de Publicación es obligatorio';
        $expectedErrors->author[] = 'El campo Artista es obligatorio';
        $this->post('/albums/create', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    /**
     * test edit success
     */
    public function testEditSuccess()
    {
        $this->put('/albums/edit/2', $this->getFormData())->seeJson([
                'status' => 'success'
        ]);
    }

    /**
     * test edit not found
     */
    public function testEditNotFound()
    {
        $this->put('/albums/edit/10000', $this->getFormDataIvalid())->seeJson([
            'status' => 'error',
            'message' => 'album no encontrado',
        ]);
    }

    /**
     * test edit invalid
     */
    public function testEditInvalid()
    {
        $expectedErrors = new \stdClass();
        $expectedErrors->title[] = 'El campo Título es obligatorio';
        $expectedErrors->published[] = 'El campo Fecha de Publicación es obligatorio';
        $expectedErrors->author[] = 'El campo Artista es obligatorio';
        $this->put('/albums/edit/2', $this->getFormDataIvalid())->seeJson([
            'status' => 'validation_error',
        ]);
    }

    public function testDetail()
    {
        $response = $this->call('GET', '/albums/detail/2');
        $data = $this->parseJson($response);
        $this->assertObjectHasAttribute('id', $data);
        $this->assertObjectHasAttribute('title', $data);
        $this->assertObjectHasAttribute('published', $data);
        $this->assertObjectHasAttribute('artist', $data);
    }

    /**
     * @param \Illuminate\Http\JsonResponse $response
     * @return mixed
     */
    protected function parseJson(Illuminate\Http\JsonResponse $response)
    {
        return json_decode($response->getContent());
    }

    /**
     *
     * @param $data
     */
    protected function assertIsJson($data)
    {
        $this->assertEquals(0, json_last_error());
    }

    protected function getFormData()
    {
        return ['title' => 'test album', 'published' => date('Y-m-d'), 'author' => [1]];
    }

    protected function getFormDataIvalid()
    {
        return ['title' => '', 'published' => '', 'author' => ''];
    }

}
