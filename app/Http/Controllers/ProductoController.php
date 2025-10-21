<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Exception; // Para manejo de errores

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos.
     * Si es AJAX, devuelve solo el contenido de la tabla/buscador.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $productos = null; // Inicializa la variable
        if (!empty($buscar)) {
            $query = Producto::query()
                ->where(function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('codigo', 'like', "%{$buscar}%")
                    ->orWhere('marca', 'like', "%{$buscar}%");
                });
            $productos = $query->paginate(10)->appends(['buscar' => $buscar]);
        } else {
            $productos = Producto::paginate(10);
        }
        if ($request->ajax()) {
            return view('productos.components.indexContent', compact('productos', 'buscar'))->render();
        }
        return view('productos.index', compact('productos', 'buscar'));
    }

    /**
     * Muestra el formulario de creación.
     * Si es AJAX, devuelve solo el formulario.
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
             // Devuelve la vista parcial del formulario de creación
            return view('productos.create')->render();
        }
        // Si no es AJAX, redirige al índice (no debería pasar con este JS)
        return redirect()->route('productos.index');
    }

    /**
     * Guarda el nuevo producto.
     * Si es AJAX, devuelve JSON.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|unique:productos,codigo',
            // Agrega aquí el resto de validaciones si son necesarias
        ]);

        try {
            Producto::create($request->all());

            if ($request->ajax()) {
                return response()->json(['message' => 'Producto registrado exitosamente.']);
            }

            return redirect()->route('productos.index')
                            ->with('success', 'Producto registrado exitosamente.');

        } catch (Exception $e) {
            if ($request->ajax()) {
                 // Devuelve un error JSON detallado
                return response()->json([
                    'message' => 'Error al registrar el producto.',
                     'error' => $e->getMessage() // Opcional: enviar detalles del error
                 ], 500); // Código de error del servidor
            }
             // Si no es AJAX, redirige atrás con el error
            return back()->withErrors(['general' => 'Error al registrar el producto: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Muestra el formulario de edición.
     * Si es AJAX, devuelve solo el formulario.
     */
    public function edit(Request $request, Producto $producto)
    {
        if ($request->ajax()) {
             // Devuelve la vista parcial del formulario de edición
            return view('productos.edit', compact('producto'))->render();
        }
        return redirect()->route('productos.index');
    }

    /**
     * Actualiza el producto.
     * Si es AJAX, devuelve JSON.
     */
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string|unique:productos,codigo,' . $producto->id,
            // Agrega validaciones restantes
        ]);

        try {
            $producto->update($request->all());

            if ($request->ajax()) {
                return response()->json(['message' => 'Producto actualizado exitosamente.']);
            }

            return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Error al actualizar el producto.',
                    'error' => $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['general' => 'Error al actualizar el producto: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Elimina el producto.
     * Si es AJAX, devuelve JSON. (Adaptado para AJAX)
     */
    public function destroy(Request $request, Producto $producto)
    {
        try {
             $producto->delete(); // Eliminación física (o soft delete si lo configuras en el modelo)

            if ($request->ajax()) {
                return response()->json(['message' => 'Producto eliminado exitosamente.']);
            }

            return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
        } catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Error al eliminar el producto.',
                    'error' => $e->getMessage()
                ], 500);
            }
            return redirect()->route('productos.index')
            ->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}