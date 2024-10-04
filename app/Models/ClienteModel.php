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

    public function obtenerClientesFiltrados($filtros)
    {
        $builder = $this->db->table($this->table);
        $builder->join('sucursales', 'sucursales.id = clientes.sucursal');
        $builder->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $builder->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');

        if (!empty($filtros['tipo'])) {
            $builder->where('clientes.tipo_consulta', $filtros['tipo']);
        }

        if (!empty($filtros['sucursal'])) {
            $builder->where('clientes.sucursal', $filtros['sucursal']);
        }

        if (!empty($filtros['estatus'])) {
            $builder->where('clientes.estatus', $filtros['estatus']);
        }

        if (!empty($filtros['periodo'])) {
            $periodo = explode(' to ', $filtros['periodo']);
            if (count($periodo) === 2) {
                $fechaInicio = date('Y-m-d', strtotime($periodo[0]));
                $fechaFin = date('Y-m-d', strtotime($periodo[1]));
                $builder->where('clientes.fecha_creado >=', $fechaInicio);
                $builder->where('clientes.fecha_creado <=', $fechaFin);
            }
        }

        $builder->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        return $builder->get()->getResultArray();
    }

    public function obtenerClientesPaginados($limit, $offset, $filtros)
    {
        $builder = $this->db->table($this->table);

        // Uniones necesarias
        $builder->join('sucursales', 'sucursales.id = clientes.sucursal', 'left');
        $builder->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus', 'left');
        $builder->join('cliente_abogado', 'cliente_abogado.id_cliente = clientes.id_cliente', 'left');
        $builder->join('usuarios', 'usuarios.id = cliente_abogado.id_usuario', 'left');

        // Selección de los campos con alias correctos
        $builder->select('clientes.*, 
                     sucursales.nombre as nombre_sucursal, 
                     clientes_estatus.nombre as nombre_estatus, 
                     clientes_estatus.descripcion as descripcion_estatus, 
                     clientes.fecha_ultima_actualizacion, 
                     clientes.tipo_consulta, 
                     clientes.meet_url,
                     usuarios.nombre as nombre_usuario_asignado');

        // Aplicar filtros
        if (!empty($filtros['tipo'])) {
            $builder->where('clientes.tipo_consulta', $filtros['tipo']);
        }

        if (!empty($filtros['sucursal'])) {
            $builder->where('clientes.sucursal', $filtros['sucursal']);
        }

        if (!empty($filtros['estatus'])) {
            if (is_array($filtros['estatus'])) {
                $builder->whereIn('clientes.estatus', $filtros['estatus']);
            } else {
                $builder->where('clientes.estatus', $filtros['estatus']);
            }
        }

        // Filtro por periodo (rango de fechas)
        if (!empty($filtros['periodo'])) {
            $periodo = explode(' to ', $filtros['periodo']);
            if (count($periodo) === 2) {
                $fechaInicio = date('Y-m-d', strtotime($periodo[0]));
                $fechaFin = date('Y-m-d', strtotime($periodo[1]));
                $builder->where('clientes.fecha_creado >=', $fechaInicio);
                $builder->where('clientes.fecha_creado <=', $fechaFin);
            }
        }

        // Filtro de búsqueda por nombre o teléfono
        if (!empty($filtros['search'])) {
            $builder->groupStart() // agrupar para OR like
                ->like('clientes.nombre', $filtros['search'])
                ->orLike('clientes.telefono', $filtros['search'])
                ->groupEnd();
        }

        // Ordenar y limitar los resultados
        $builder->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        $builder->limit($limit, $offset);

        // Obtener resultados
        $result = $builder->get()->getResultArray();

        // Obtener el total de registros para la paginación
        $builder->select("COUNT(*) as total", false); // evitar conflicto de alias
        $countQuery = clone $builder;
        $total = $countQuery->get()->getRow()->total;

        return [
            'total' => $total,
            'rows' => $result
        ];
    }




    public function obtenerClientesAsignadosPaginados($idUsuario, $limit, $offset, $filtros)
    {
        $builder = $this->db->table($this->table);
        $builder->join('sucursales', 'sucursales.id = clientes.sucursal');
        $builder->join('clientes_estatus', 'clientes_estatus.id_cliente_estatus = clientes.estatus');
        $builder->join('cliente_abogado', 'cliente_abogado.id_cliente = clientes.id_cliente');
        $builder->select('clientes.*, sucursales.nombre as nombre_sucursal, clientes_estatus.nombre as nombre_estatus, clientes_estatus.descripcion as descripcion_estatus, clientes.fecha_ultima_actualizacion, clientes.tipo_consulta, clientes.meet_url');
        $builder->where('cliente_abogado.id_usuario', $idUsuario);

        // Aplicar filtros
        if (!empty($filtros['tipo'])) {
            $builder->where('clientes.tipo_consulta', $filtros['tipo']);
        }

        if (!empty($filtros['sucursal'])) {
            $builder->where('clientes.sucursal', $filtros['sucursal']);
        }

        if (!empty($filtros['estatus'])) {
            $builder->where('clientes.estatus', $filtros['estatus']);
        }

        if (!empty($filtros['periodo'])) {
            $periodo = explode(' to ', $filtros['periodo']);
            if (count($periodo) === 2) {
                $fechaInicio = date('Y-m-d', strtotime($periodo[0]));
                $fechaFin = date('Y-m-d', strtotime($periodo[1]));
                $builder->where('clientes.fecha_creado >=', $fechaInicio);
                $builder->where('clientes.fecha_creado <=', $fechaFin);
            }
        }

        $builder->orderBy('clientes.fecha_ultima_actualizacion', 'desc');
        $builder->limit($limit, $offset);

        $result = $builder->get()->getResultArray();

        // Obtener el total de registros para la paginación
        $countQuery = clone $builder;
        $countQuery->select("COUNT(*) as total");
        $total = $countQuery->get()->getRow()->total;

        return [
            'total' => $total,
            'rows' => $result
        ];
    }
}
