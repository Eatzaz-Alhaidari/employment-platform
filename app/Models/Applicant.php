<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Applicant extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applicants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'national_id',
        'gender',
        'birth_date',
        'nationality',
        'cv_path',
        'id_path',
        'status',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Get the public URL for the CV file.
     */
    public function getCvUrlAttribute(): ?string
    {
        return $this->cv_path ? Storage::url($this->cv_path) : null;
    }

    /**
     * Get the public URL for the ID document.
     */
    public function getIdUrlAttribute(): ?string
    {
        return $this->id_path ? Storage::url($this->id_path) : null;
    }

    /**
     * Get CSS badge class according to status.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'جديد' => 'badge-new',
            'قيد المراجعة' => 'badge-review',
            'مقبول' => 'badge-accepted',
            'مرفوض' => 'badge-rejected',
            default => 'badge-default',
        };
    }
}
