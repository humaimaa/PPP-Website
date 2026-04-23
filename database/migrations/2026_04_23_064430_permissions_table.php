<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $teams = config('permission.teams');
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $pivotRole = $columnNames['role_pivot_key'] ?? 'role_id';
        $pivotPermission = $columnNames['permission_pivot_key'] ?? 'permission_id';

        throw_if(empty($tableNames), 'Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        throw_if($teams && empty($columnNames['team_foreign_key'] ?? null), 'Error: team_foreign_key on config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        // Create Permissions Table
        Schema::create($tableNames['permissions'], static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->string('module')->nullable(); // Added module column for grouping
            $table->string('description')->nullable(); // Added description for clarity
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        // Create Roles Table
        Schema::create($tableNames['roles'], static function (Blueprint $table) use ($teams, $columnNames) {
            $table->id();
            if ($teams || config('permission.testing')) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'])->nullable();
                $table->index($columnNames['team_foreign_key'], 'roles_team_foreign_key_index');
            }
            $table->string('name');
            $table->string('guard_name');
            $table->string('description')->nullable(); // Added description
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'], 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        // Create Model Has Permissions Table
        Schema::create($tableNames['model_has_permissions'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotPermission, $teams) {
            $table->unsignedBigInteger($pivotPermission);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->cascadeOnDelete();
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_permissions_team_foreign_key_index');
                $table->primary([$columnNames['team_foreign_key'], $pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary([$pivotPermission, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }
        });

        // Create Model Has Roles Table
        Schema::create($tableNames['model_has_roles'], static function (Blueprint $table) use ($tableNames, $columnNames, $pivotRole, $teams) {
            $table->unsignedBigInteger($pivotRole);
            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');
            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->cascadeOnDelete();
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key']);
                $table->index($columnNames['team_foreign_key'], 'model_has_roles_team_foreign_key_index');
                $table->primary([$columnNames['team_foreign_key'], $pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary([$pivotRole, $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        // Create Role Has Permissions Table
        Schema::create($tableNames['role_has_permissions'], static function (Blueprint $table) use ($tableNames, $pivotRole, $pivotPermission) {
            $table->unsignedBigInteger($pivotPermission);
            $table->unsignedBigInteger($pivotRole);
            $table->foreign($pivotPermission)
                ->references('id')
                ->on($tableNames['permissions'])
                ->cascadeOnDelete();
            $table->foreign($pivotRole)
                ->references('id')
                ->on($tableNames['roles'])
                ->cascadeOnDelete();
            $table->primary([$pivotPermission, $pivotRole], 'role_has_permissions_permission_id_role_id_primary');
        });

        // Insert Default Permissions
        $this->seedPermissions($tableNames);

        // Insert Default Roles
        $this->seedRoles($tableNames);

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Seed permissions for all modules
     */
    private function seedPermissions($tableNames): void
    {
        $modules = [
            'projects' => 'Projects',
            'tenders' => 'Tenders',
            'news' => 'News/Updates',
            'gallery' => 'Gallery',
            'team' => 'Team Members',
            'leadership' => 'Leadership Messages',
            'downloads' => 'Downloads/Documents',
            'designations' => 'Designations',
            'sectors' => 'Sectors',
            'roles' => 'Roles & Permissions',
            'settings' => 'Settings',
            'registrations' => 'User Registrations',
        ];

        $actions = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'manage' => 'Manage', // For special actions like publish/unpublish, toggle status
        ];

        $permissions = [];

        foreach ($modules as $moduleKey => $moduleName) {
            foreach ($actions as $actionKey => $actionName) {
                $permissions[] = [
                    'name' => "{$moduleKey}.{$actionKey}",
                    'guard_name' => 'web',
                    'module' => $moduleName,
                    'description' => "{$actionName} {$moduleName}",
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Additional specific permissions
        $additionalPermissions = [
            ['name' => 'tenders.extend', 'guard_name' => 'web', 'module' => 'Tenders', 'description' => 'Extend Tender Dates'],
            ['name' => 'tenders.archive', 'guard_name' => 'web', 'module' => 'Tenders', 'description' => 'Archive/Unarchive Tenders'],
            ['name' => 'gallery.set_thumbnail', 'guard_name' => 'web', 'module' => 'Gallery', 'description' => 'Set Gallery Thumbnail'],
            ['name' => 'gallery.publish', 'guard_name' => 'web', 'module' => 'Gallery', 'description' => 'Publish/Unpublish Gallery'],
            ['name' => 'team.reorder', 'guard_name' => 'web', 'module' => 'Team Members', 'description' => 'Reorder Team Members'],
            ['name' => 'bulk.actions', 'guard_name' => 'web', 'module' => 'General', 'description' => 'Perform Bulk Actions'],
            ['name' => 'dashboard.access', 'guard_name' => 'web', 'module' => 'Dashboard', 'description' => 'Access Dashboard'],
        ];

        foreach ($additionalPermissions as $permission) {
            $permissions[] = array_merge($permission, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table($tableNames['permissions'])->insert($permissions);
    }

    /**
     * Seed default roles
     */
    private function seedRoles($tableNames): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'web',
                'description' => 'Has full access to all features and settings',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'web',
                'description' => 'Can manage all content but limited system settings',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Editor',
                'guard_name' => 'web',
                'description' => 'Can create and edit content but cannot delete',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Viewer',
                'guard_name' => 'web',
                'description' => 'Read-only access to view content',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table($tableNames['roles'])->insert($roles);

        // Assign all permissions to Super Admin role
        $superAdminRoleId = 1; // First role is Super Admin
        $allPermissions = DB::table($tableNames['permissions'])->pluck('id');
        
        $roleHasPermissions = [];
        foreach ($allPermissions as $permissionId) {
            $roleHasPermissions[] = [
                'role_id' => $superAdminRoleId,
                'permission_id' => $permissionId,
            ];
        }
        
        DB::table($tableNames['role_has_permissions'])->insert($roleHasPermissions);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');

        throw_if(empty($tableNames), 'Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
};