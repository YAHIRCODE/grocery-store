<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    /**
     * Un usuario tiene un empleado asociado
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /*
    |--------------------------------------------------------------------------
    | MÉTODOS DE ROLES
    |--------------------------------------------------------------------------
    */

    /**
     * Verificar si el usuario es Administrador
     */
    public function isAdmin(): bool
    {
        if (!$this->employee || !$this->employee->role) {
            return false;
        }
        
        return $this->employee->role->name === 'Administrador';
    }

    /**
     * Verificar si el usuario es Cajero
     */
    public function isCashier(): bool
    {
        if (!$this->employee || !$this->employee->role) {
            return false;
        }
        
        return $this->employee->role->name === 'Cajero';
    }

    /**
     * Verificar si el usuario es Almacenista
     */
    public function isWarehouseWorker(): bool
    {
        if (!$this->employee || !$this->employee->role) {
            return false;
        }
        
        return $this->employee->role->name === 'Almacenista';
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole(string $roleName): bool
    {
        if (!$this->employee || !$this->employee->role) {
            return false;
        }
        
        return $this->employee->role->name === $roleName;
    }

    /**
     * Obtener el rol del usuario
     */
    public function getRole(): ?string
    {
        if (!$this->employee || !$this->employee->role) {
            return null;
        }
        
        return $this->employee->role->name;
    }

    /**
     * Obtener el nombre completo del empleado asociado
     */
    public function getEmployeeFullName(): string
    {
        if (!$this->employee) {
            return $this->name;
        }
        
        return $this->employee->first_name . ' ' . $this->employee->last_name;
    }

    /**
     * Verificar si el usuario puede acceder a ventas
     */
    public function canManageSales(): bool
    {
        return $this->isAdmin() || $this->isCashier();
    }

    /**
     * Verificar si el usuario puede acceder a inventario
     */
    public function canManageInventory(): bool
    {
        return $this->isAdmin() || $this->isWarehouseWorker();
    }

    /**
     * Verificar si el usuario puede acceder a clientes
     */
    public function canManageClients(): bool
    {
        return $this->isAdmin() || $this->isCashier();
    }

    /**
     * Verificar si el usuario puede gestionar empleados
     */
    public function canManageEmployees(): bool
    {
        return $this->isAdmin();
    }
}