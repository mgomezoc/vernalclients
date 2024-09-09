<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class DocumentoCasoModel extends Model
{
    protected $table = 'documentos_caso';
    protected $primaryKey = 'id_documento';

    protected $allowedFields = [
        'id_caso',
        'nombre_documento',
        'path_documento',
        'tipo_documento',
        'tamano_documento',
        'fecha_subida',
        'subido_por'
    ];

    protected $useTimestamps = false;
    protected $validationRules = [
        'id_caso' => 'required|integer',
        'nombre_documento' => 'required|string|max_length[255]',
        'path_documento' => 'required|string|max_length[500]',
        'tipo_documento' => 'required|string|max_length[50]',
        'tamano_documento' => 'permit_empty|integer|max_length[53687091200]', // Hasta 50 MB
        'subido_por' => 'permit_empty|integer'
    ];

    protected $skipValidation = false;

    public function subirDocumento($documento, int $idCaso, int $usuarioID)
    {
        // Verificar si el archivo es válido
        if (!$documento->isValid()) {
            throw new \RuntimeException($documento->getErrorString() . '(' . $documento->getError() . ')');
        }

        // Obtener MimeType antes de mover el archivo
        $mimeType = $documento->getMimeType();

        // Validar el tipo de archivo permitido
        if (!in_array($mimeType, ['application/pdf', 'image/jpeg', 'image/png', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
            throw new \Exception('Tipo de archivo no permitido.');
        }

        // Validar el tamaño del archivo (máximo 50 MB)
        if ($documento->getSize() > 52428800) { // 50 MB
            throw new \Exception('El tamaño del archivo excede el límite permitido de 50 MB.');
        }

        // Crear directorio si no existe
        $rutaArchivo = WRITEPATH . 'uploads/casos/' . $idCaso . '/';
        if (!is_dir($rutaArchivo)) {
            mkdir($rutaArchivo, 0755, true);
        }

        // Generar nombre aleatorio para evitar conflictos
        $nuevoNombreArchivo = $documento->getRandomName();

        // Mover el archivo al servidor
        if (!$documento->move($rutaArchivo, $nuevoNombreArchivo)) {
            throw new \Exception('No se pudo mover el archivo al servidor.');
        }

        // Guardar detalles del archivo en la base de datos
        $datosDocumento = [
            'id_caso' => $idCaso,
            'nombre_documento' => $documento->getClientName(),
            'path_documento' => $rutaArchivo . $nuevoNombreArchivo,
            'tipo_documento' => $mimeType, // Usa el MimeType obtenido antes de mover el archivo
            'tamano_documento' => $documento->getSize(),
            'subido_por' => $usuarioID,
            'fecha_subida' => date('Y-m-d H:i:s')
        ];

        // Inserta los datos en la base de datos
        return $this->insert($datosDocumento);
    }



    public function obtenerDocumentosPorCaso(int $idCaso)
    {
        return $this->where('id_caso', $idCaso)->orderBy('fecha_subida', 'DESC')->findAll();
    }

    public function eliminarDocumento(int $idDocumento)
    {
        $documento = $this->find($idDocumento);
        if (!$documento) {
            throw new Exception('Documento no encontrado.');
        }

        if (is_file($documento['path_documento']) && !unlink($documento['path_documento'])) {
            throw new Exception('No se pudo eliminar el archivo del servidor.');
        }

        return $this->delete($idDocumento);
    }
}
