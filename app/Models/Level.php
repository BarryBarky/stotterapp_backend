<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Level extends Model
{
    use HasFactory;

    protected $fillable = ["title", "text", "time", "variant_id"];

    const EXCERPT_LENGTH = 100;

    public function excerpt()
    {
        return Str::limit($this->text, Level::EXCERPT_LENGTH);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(Variant::class);
    }

    public function hints(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Hint::class, 'hint_level');
    }
}
