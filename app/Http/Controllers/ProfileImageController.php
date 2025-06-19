<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ImagenesPerfil;
use App\Models\AstrologicalUser; // Asegúrate de importar el modelo
use Illuminate\Support\Facades\File; // Usaremos la clase File para manejar directorios

class ProfileImageController extends Controller
{
    /**
     * Sube una nueva imagen de perfil adicional o actualiza una existente.
     * Esta función maneja la subida individual de imágenes cuando
     * se hace clic en "Guardar Cambios" desde el frontend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        // Valida que la solicitud contenga una imagen y un orden válido.
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Máximo 2MB
            'order' => 'required|integer|min:1|max:5', // Orden de la imagen (1 a 5)
        ]);

        $user = Auth::user();
        if (!$user) {
            // Retorna un error si el usuario no está autenticado.
            return response()->json(['message' => 'Usuario no autenticado.'], 401);
        }

        $image = $request->file('image');
        $order = $request->input('order');

        // Definir la ruta de destino dentro de la carpeta 'public'.
        // Esto guardará las imágenes directamente en public/images/upload/img_perfil/{user_id}/
        $destinationFolder = 'images/upload/img_perfil/' . $user->id;
        $destinationPath = public_path($destinationFolder);

        // Generar un nombre único para la imagen para evitar colisiones.
        // Usamos time() para el timestamp y uniqid() para mayor unicidad.
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

        // Asegurarse de que el directorio de destino exista. Si no, crearlo.
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true); // Crear directorio con permisos y recursivamente
        }

        // Mover la imagen al directorio público.
        $image->move($destinationPath, $imageName);

        // La URL relativa pública que se guardará en la base de datos.
        // Ejemplo: images/upload/img_perfil/{user_id}/nombre_imagen.jpg
        $publicRelativeUrl = $destinationFolder . '/' . $imageName;

        // Buscar si ya existe una imagen para este usuario y orden.
        $profileImage = ImagenesPerfil::where('id_usuario', $user->id)
                                    ->where('orden', $order)
                                    ->first();

        if ($profileImage) {
            // Si ya existe una imagen para este orden, eliminar la antigua del almacenamiento.
            // Asegúrate de que $profileImage->url_imagen contenga la ruta relativa que guardamos.
            $oldImagePath = public_path($profileImage->url_imagen);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath); // Eliminar el archivo físico
            }
            // Actualizar el registro existente con la nueva imagen y fecha.
            $profileImage->url_imagen = $publicRelativeUrl;
            $profileImage->fecha_subida = now();
            $profileImage->save();
        } else {
            // Si no existe, crear un nuevo registro en la base de datos.
            ImagenesPerfil::create([
                'id_usuario' => $user->id,
                'url_imagen' => $publicRelativeUrl, // Guardar la ruta relativa pública
                'orden' => $order,
                'fecha_subida' => now(),
            ]);
        }

        // Retorna una respuesta JSON con el mensaje de éxito y la URL pública completa.
        // La URL pública completa se genera usando asset() para que el navegador la resuelva.
        return response()->json([
            'message' => 'Imagen subida correctamente.',
            'url' => asset($publicRelativeUrl) // Devolvemos la URL completa para el frontend
        ], 200);
    }

    /**
     * Elimina una imagen de perfil adicional.
     * Esta función maneja la eliminación individual de imágenes cuando
     * se hace clic en "Guardar Cambios" desde el frontend.
     *
     * @param  int  $id  ID de la imagen a eliminar
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage($id)
    {
        $user = Auth::user();
        if (!$user) {
            // Retorna un error si el usuario no está autenticado.
            return response()->json(['message' => 'Usuario no autenticado.'], 401);
        }

        // Buscar la imagen en la base de datos asegurándose de que pertenece al usuario.
        $image = ImagenesPerfil::where('id_imagen', $id)
                               ->where('id_usuario', $user->id)
                               ->first();

        if (!$image) {
            // Retorna un error si la imagen no se encuentra o no pertenece al usuario.
            return response()->json(['message' => 'Imagen no encontrada o no pertenece al usuario.'], 404);
        }

        // Eliminar el archivo físico del almacenamiento.
        // Usamos public_path() para obtener la ruta absoluta al archivo.
        $filePath = public_path($image->url_imagen);
        if (File::exists($filePath)) {
            File::delete($filePath); // Eliminar el archivo físico
        }

        // Eliminar el registro de la base de datos.
        $image->delete();

        // Retorna una respuesta JSON con el mensaje de éxito.
        return response()->json(['message' => 'Imagen eliminada correctamente.'], 200);
    }
}
