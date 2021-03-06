<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Backend\CreateCategoriaRequest;
use App\Http\Requests\Backend\UpdateCategoriaRequest;
use App\Repositories\Backend\CategoriaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CategoriaController extends AppBaseController
{
    /** @var  CategoriaRepository */
    private $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepo)
    {
      
        $this->categoriaRepository = $categoriaRepo;
    }

    /**
     * Display a listing of the Categoria.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->categoriaRepository->pushCriteria(new RequestCriteria($request));
        $categorias = $this->categoriaRepository->all();

        return view('backend.categorias.index')
            ->with('categorias', $categorias);
    }

    /**
     * Show the form for creating a new Categoria.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.categorias.create');
    }

    /**
     * Store a newly created Categoria in storage.
     *
     * @param CreateCategoriaRequest $request
     *
     * @return Response
     */
    public function store(CreateCategoriaRequest $request)
    {
        $input = $request->all();

        $categoria = $this->categoriaRepository->create($input);

        Flash::success('Categoria guardada exitosamente');

        return redirect(route('backend.categorias.index'));
    }

    /**
     * Display the specified Categoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $categoria = $this->categoriaRepository->findWithoutFail($id);

        if (empty($categoria)) {
            Flash::error('Categoria no encontrada');

            return redirect(route('backend.categorias.index'));
        }

        return view('backend.categorias.show')->with('categoria', $categoria);
    }

    /**
     * Show the form for editing the specified Categoria.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $categoria = $this->categoriaRepository->findWithoutFail($id);

        if (empty($categoria)) {
            Flash::error('Categoria no encontrada');

            return redirect(route('backend.categorias.index'));
        }

        return view('backend.categorias.edit')->with('categoria', $categoria);
    }

    /**
     * Update the specified Categoria in storage.
     *
     * @param  int              $id
     * @param UpdateCategoriaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCategoriaRequest $request)
    {
        $categoria = $this->categoriaRepository->findWithoutFail($id);

        if (empty($categoria)) {
            Flash::error('Categoria no encontrada');

            return redirect(route('backend.categorias.index'));
        }

        $categoria = $this->categoriaRepository->update($request->all(), $id);

        Flash::success('Categoria actualizada exitosamente');

        return redirect(route('backend.categorias.index'));
    }

    /**
     * Remove the specified Categoria from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $categoria = $this->categoriaRepository->findWithoutFail($id);

        if (empty($categoria)) {
            Flash::error('Categoria no encontrada');

            return redirect(route('backend.categorias.index'));
        }
        $productos = $categoria->productos()->first();
        if (!empty($productos)){
            Flash::error('No es posible eliminar la Categoria dado que tiene Productos asociados');

            return redirect(route('backend.categorias.index'));
        }
        $this->categoriaRepository->delete($id);

        Flash::success('Categoria borrada exitosamente');

        return redirect(route('backend.categorias.index'));
    }
}
