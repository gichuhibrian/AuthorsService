<?php

namespace App\Http\Controllers;

use App\Author;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * obtains the list of authors
     */
    public function index()
     {
        $authors = Author::all();
        return $this->successResponse($authors);
     }

     /**
      * create a new author
      */
    public function store(Request $request)
    {
        $this->validation($request);
        $author = Author::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
      * obtains one author information
      */
      public function show($author)
      {
        $author = Author::findOrFail($author);
        return $this->successResponse($author);
      }

    /**
      * updates author information
      */
      public function update(Request $request, $author)
      {
        $this->validation($request);
        $author = Author::findOrFail($author);

        $author->fill($request->all());

        if($author->isClean())
        {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $author->save();
        
        return $this->successResponse($author);
      }

    /**
      * removes an existing author
      */
      public function destroy($author)
      {
        $author= Author::findOrFail($author);
        $author->delete();
        
        return $this->successResponse($author);
      }

      private function validation($data)
      {
        $rules=[
            'name' => 'max:255|min:3',
            'gender' => 'max:255|in:male,female',
            'country' => 'max:255'
        ];
        $this->validate($data, $rules);
      }
}
