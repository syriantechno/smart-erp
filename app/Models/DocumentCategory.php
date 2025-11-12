<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'color',
        'icon',
        'parent_id',
        'company_id',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(DocumentCategory::class, 'parent_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Accessors
    public function getFullPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' / ', $path);
    }

    public function getDocumentCountAttribute()
    {
        return $this->documents()->active()->count();
    }

    public function getTotalDocumentCountAttribute()
    {
        $count = $this->document_count;

        foreach ($this->children as $child) {
            $count += $child->total_document_count;
        }

        return $count;
    }

    // Methods
    public function getHierarchyLevel()
    {
        $level = 0;
        $parent = $this->parent;

        while ($parent) {
            $level++;
            $parent = $parent->parent;
        }

        return $level;
    }

    public function moveTo($newParentId)
    {
        // Prevent circular references
        if ($newParentId) {
            $newParent = self::find($newParentId);
            if ($newParent && $this->isDescendantOf($newParent)) {
                throw new \Exception('Cannot move category to its own descendant');
            }
        }

        $this->update(['parent_id' => $newParentId]);
    }

    private function isDescendantOf($category)
    {
        $parent = $this->parent;

        while ($parent) {
            if ($parent->id === $category->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}
