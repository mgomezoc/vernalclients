<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSucursalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'direccion' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'url_google_maps' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'imagen' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'fecha_creacion' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('sucursales');
    }

    public function down()
    {
        $this->forge->dropTable('sucursales');
    }
}
