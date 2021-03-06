<?php

namespace App\Models;

use App\Models\Share\Email;
use App\Models\Share\Telegram;
use App\Models\Share\Viber;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property SharedQuote[] $sharedQuotes
 */
class Quote extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'source', 'text', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sharedQuotes()
    {
        return $this->hasMany(SharedQuote::class);
    }

    public function getShareTypes()
    {
        return [
            new Telegram(),
            new Viber(),
            new Email(),
        ];
    }
}
