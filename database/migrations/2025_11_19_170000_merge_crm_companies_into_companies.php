<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tables that reference CRM companies via company_id.
     */
    protected array $crmRelatedTables = [
        'crm_contacts',
        'crm_leads',
        'crm_opportunities',
        'crm_tasks',
        'crm_activities',
    ];

    public function up(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'industry')) {
                $table->string('industry')->nullable()->after('website');
            }

            if (!Schema::hasColumn('companies', 'company_size')) {
                $table->string('company_size')->nullable()->after('industry');
            }

            if (!Schema::hasColumn('companies', 'status')) {
                $table->string('status')->default('active')->after('company_size');
            }

            if (!Schema::hasColumn('companies', 'tags')) {
                $table->json('tags')->nullable()->after('status');
            }

            if (!Schema::hasColumn('companies', 'notes')) {
                $table->text('notes')->nullable()->after('tags');
            }
        });

        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'owner_id')) {
                $table->foreignId('owner_id')->nullable()->after('notes')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('companies', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('owner_id')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('companies', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            }
        });

        $this->dropCompanyForeignKeys();

        $idMap = $this->migrateCrmCompaniesIntoCore();

        $this->remapCompanyIds($idMap);

        $this->addCompanyForeignKeys();

        if (Schema::hasTable('crm_companies')) {
            Schema::drop('crm_companies');
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('crm_companies')) {
            Schema::create('crm_companies', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('industry')->nullable();
                $table->string('company_size')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('country')->nullable();
                $table->string('city')->nullable();
                $table->string('address')->nullable();
                $table->string('status')->default('active');
                $table->unsignedBigInteger('owner_id')->nullable();
                $table->unsignedBigInteger('created_by')->nullable();
                $table->unsignedBigInteger('updated_by')->nullable();
                $table->json('tags')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('owner_id')->references('id')->on('users')->nullOnDelete();
                $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
                $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            });
        }

        $this->dropCompanyForeignKeys();

        // Copy current companies into crm_companies so rollback keeps data accessible.
        if (Schema::hasTable('companies')) {
            $existing = DB::table('crm_companies')->count();

            if ($existing === 0) {
                $companies = DB::table('companies')->orderBy('id')->get();

                foreach ($companies as $company) {
                    DB::table('crm_companies')->insert([
                        'id' => $company->id,
                        'name' => $company->name,
                        'industry' => $company->industry,
                        'company_size' => $company->company_size,
                        'website' => $company->website,
                        'email' => $company->email,
                        'phone' => $company->phone,
                        'country' => $company->country,
                        'city' => $company->city,
                        'address' => $company->address,
                        'status' => $company->status ?? ($company->is_active ? 'active' : 'inactive'),
                        'owner_id' => $company->owner_id,
                        'created_by' => $company->created_by,
                        'updated_by' => $company->updated_by,
                        'tags' => $company->tags,
                        'notes' => $company->notes,
                        'created_at' => $company->created_at,
                        'updated_at' => $company->updated_at,
                        'deleted_at' => $company->deleted_at,
                    ]);
                }
            }
        }

        $this->addLegacyCrmForeignKeys();

        Schema::table('companies', function (Blueprint $table) {
            if (Schema::hasColumn('companies', 'updated_by')) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');
            }

            if (Schema::hasColumn('companies', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }

            if (Schema::hasColumn('companies', 'owner_id')) {
                $table->dropForeign(['owner_id']);
                $table->dropColumn('owner_id');
            }

            if (Schema::hasColumn('companies', 'notes')) {
                $table->dropColumn('notes');
            }

            if (Schema::hasColumn('companies', 'tags')) {
                $table->dropColumn('tags');
            }

            if (Schema::hasColumn('companies', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('companies', 'company_size')) {
                $table->dropColumn('company_size');
            }

            if (Schema::hasColumn('companies', 'industry')) {
                $table->dropColumn('industry');
            }
        });
    }

    private function dropCompanyForeignKeys(): void
    {
        foreach ($this->crmRelatedTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'company_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                try {
                    $table->dropForeign(['company_id']);
                } catch (\Throwable $e) {
                    // FK might already be absent; ignore.
                }
            });
        }
    }

    private function addCompanyForeignKeys(): void
    {
        foreach ($this->crmRelatedTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'company_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('company_id')->references('id')->on('companies')->nullOnDelete();
            });
        }
    }

    private function addLegacyCrmForeignKeys(): void
    {
        foreach ($this->crmRelatedTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'company_id')) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) {
                $table->foreign('company_id')->references('id')->on('crm_companies')->nullOnDelete();
            });
        }
    }

    /**
     * Copy CRM-specific companies into the unified table.
     *
     * @return array<int, int> Mapping of old CRM company IDs => new unified IDs
     */
    private function migrateCrmCompaniesIntoCore(): array
    {
        if (!Schema::hasTable('crm_companies')) {
            return [];
        }

        $idMap = [];
        $now = now();

        $crmCompanies = DB::table('crm_companies')->orderBy('id')->get();

        foreach ($crmCompanies as $crmCompany) {
            $newId = DB::table('companies')->insertGetId([
                'name' => $crmCompany->name ?? (__('CRM Company #') . $crmCompany->id),
                'industry' => $crmCompany->industry,
                'company_size' => $crmCompany->company_size,
                'website' => $crmCompany->website,
                'email' => $crmCompany->email,
                'phone' => $crmCompany->phone,
                'country' => $crmCompany->country,
                'city' => $crmCompany->city,
                'address' => $crmCompany->address,
                'status' => $crmCompany->status ?? 'active',
                'owner_id' => $crmCompany->owner_id,
                'created_by' => $crmCompany->created_by,
                'updated_by' => $crmCompany->updated_by,
                'tags' => $crmCompany->tags,
                'notes' => $crmCompany->notes,
                'is_active' => $crmCompany->status !== 'inactive',
                'created_at' => $crmCompany->created_at ?? $now,
                'updated_at' => $crmCompany->updated_at ?? $now,
                'deleted_at' => $crmCompany->deleted_at,
            ]);

            $idMap[$crmCompany->id] = $newId;
        }

        return $idMap;
    }

    /**
     * Update related tables to reference the newly created company IDs.
     */
    private function remapCompanyIds(array $idMap): void
    {
        if (empty($idMap)) {
            return;
        }

        foreach ($this->crmRelatedTables as $tableName) {
            if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'company_id')) {
                continue;
            }

            foreach ($idMap as $oldId => $newId) {
                DB::table($tableName)->where('company_id', $oldId)->update(['company_id' => $newId]);
            }
        }
    }
};
