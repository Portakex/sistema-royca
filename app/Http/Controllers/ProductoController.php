<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos (READ).
     */
    public function index()
    {
        $productos = Producto::paginate(10); // Pagina de 10 en 10
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario de creación (CREATE).
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Guarda el nuevo producto en la base de datos (CREATE).
     */
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|unique:productos,codigo', // Opcional, pero único si existe
        ]);

        // Creación
        Producto::create($request->all());

        // Redirección
        return redirect()->route('productos.index')
        ->with('success', 'Producto registrado exitosamente.');
    }

    /**
     * Display the specified resource.
     * (No lo usaremos por ahora)
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Muestra el formulario de edición (UPDATE).
     */
    public function edit(Producto $producto)
    {
        // Laravel automáticamente encuentra el producto por su ID
        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza el producto en la base de datos (UPDATE).
     */
    public function update(Request $request, Producto $producto)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
             // Validación de único, ignorando el ID actual
            'codigo' => 'nullable|string|unique:productos,codigo,' . $producto->id,
        ]);

        // Actualización
        $producto->update($request->all());

        // Redirección
        return redirect()->route('productos.index')
        ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Elimina el producto de la base de datos (DELETE).
     */
    public function destroy(Producto $producto)
{
    $producto->delete();

    // Cambia el mensaje aquí para incluir el emoji manualmente
    return redirect()->route('productos.index')
    ->with('success', 'Producto eliminado exitosamente.');
}
}