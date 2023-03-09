<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($blog) {
            $blog->user_id = Auth::id() ?? $blog->user_id;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
        //Or: return $this->belongsTo(Profile::class, 'foreign_key');
    }
}
