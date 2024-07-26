<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = [
        'nombre',
        'telefono',
        'sucursal',
        'slug',
        'estatus',
        'clientID',
        'fecha_ultima_actualizacion',
        'tipo_consulta',
        'meet_url'
    ];

    public function obtenerTodosClientes()
    {
        $this->join('sucursales', 'sucursales.id = clientes.sucursal');
        $this->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $this->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $this->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $this->findAll();
    }

    public function obtenerTodosClientesConEstatus($estatus)
    {
        $this->join('sucursales', 'sucursales.id = clientes.sucursal');
        $this->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $this->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $this->where('clientes.estatus', $estatus);
        $this->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $this->findAll();
    }

    public function obtenerTodosClientesAbogado($idUsuario)
    {
        $this->join('sucursales', 'sucursales.id = clientes.sucursal');
        $this->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $this->join('cliente_abogado', 'cliente_abogado.id_cliente = clientes.id_cliente');
        $this->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $this->where('clientes.estatus', 3);
        $this->where('cliente_abogado.id_usuario', $idUsuario);
        $this->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $this->findAll();
    }

    public function actualizarEstatusCliente($idCliente, $nuevoEstatus)
    {
        $data = [
            'estatus' => $nuevoEstatus,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        $this->where('id_cliente', $idCliente);

        if ($this->update($idCliente, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function actualizarClientID($idCliente, $nuevoClientID)
    {
        $data = [
            'clientID' => $nuevoClientID,
            'fecha_ultima_actualizacion' => date('Y-m-d H:i:s')
        ];

        $this->where('id_cliente', $idCliente);

        if ($this->update($idCliente, $data)) {
            return true; // La actualización se realizó correctamente.
        } else {
            return false; // Ocurrió un error al actualizar.
        }
    }

    public function buscarClientes($term)
    {
        return $this->like('nombre', $term)
            ->orLike('telefono', $term)
            ->findAll();
    }

    public function obtenerClientesPorEstatus($estatuses)
    {
        $this->join('sucursales', 'sucursales.id = clientes.sucursal');
        $this->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $this->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $this->whereIn('clientes.estatus', $estatuses);
        $this->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $this->findAll();
    }

    public function obtenerClientesAsignados($idUsuario)
    {
        $this->join('sucursales', 'sucursales.id = clientes.sucursal');
        $this->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $this->join('cliente_abogado', 'cliente_abogado.id_cliente = clientes.id_cliente');
        $this->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $this->where('cliente_abogado.id_usuario', $idUsuario);
        $this->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $this->findAll();
    }
}
